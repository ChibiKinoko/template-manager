<?php

namespace App;

use App\Context\ApplicationContext;
use App\Entity\Instructor;
use App\Entity\Learner;
use App\Entity\Lesson;
use App\Entity\Template;
use App\Repository\InstructorRepository;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;

class TemplateManager
{
    /**
     * Get the template computed
     * @param Template $tpl
     * @param array    $data
     * @return Template
     */
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone ($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    /**
     * Compute template with data
     * @param  string $text
     * @param  array  $data
     * @return string
     */
    private function computeText(string $text, array $data): string
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        $lesson = (isset($data['lesson']) and $data['lesson'] instanceof Lesson) ? $data['lesson'] : null;
        $user = (isset($data['user']) and ($data['user'] instanceof Learner)) ? $data['user'] : $APPLICATION_CONTEXT->getCurrentUser();

        if ($lesson) {
            $lessonRepository   = LessonRepository::getInstance()->getById($lesson->id) ?? null;
            $meetingPoint       = MeetingPointRepository::getInstance()->getById($lesson->meetingPointId) ?? null;
            $instructorOfLesson = InstructorRepository::getInstance()->getById($lesson->instructorId) ?? null;

            $mapping = [
                '[lesson:summary_html]'    => Lesson::renderHtml($lessonRepository),
                '[lesson:summary]'         => Lesson::renderText($lessonRepository),
                '[lesson:instructor_name]' => $instructorOfLesson->firstname,
                '[lesson:instructor_link]' => 'instructors/' . $instructorOfLesson->id . '-' . urlencode($instructorOfLesson->firstname),
                '[lesson:meeting_point]'   => $meetingPoint->name,
                '[lesson:start_date]'      => $lesson->start_time->format('d/m/Y'),
                '[lesson:start_time]'      => $lesson->start_time->format('H:i'),
                '[lesson:end_time]'        => $lesson->end_time->format('H:i'),
                '[user:first_name]'        => ucfirst(strtolower($user->firstname))
            ];
        }

        /*
         * USER
         * [user:*]
         */
        if ($user) {
            $mapping['[user:first_name]'] = ucfirst(strtolower($user->firstname));
        }

        foreach ($mapping as $key => $value) {
            if (!$value) continue;

            $this->replace($text, $key, $value);
        }

        return $text;
    }

    /**
     * Replace tag with appropriate value
     * @param string $text
     * @param string $tag
     * @param string $value
     * @return string
     */
    private function replace($text, string $tag, string $value): string
    {
        if (strpos($text, $tag) === false) return false;

        $text = str_replace(
            $tag,
            $value,
            $text
        );
        return $text;
    }
}
