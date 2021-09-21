<?php

namespace App\Entity;

class Lesson
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $meetingPointId;

    /**
     * @var int
     */
    public int $instructorId;

    /**
     * @var DateTime
     */
    public \DateTime $start_time;

    /**
     * @var DateTime
     */
    public \DateTime $end_time;

    /**
     * Lesson Entity constructor
     * @param  int       $id
     * @param  int       $meetingPointId
     * @param  int       $instructorId
     * @param  \DateTime $start_time
     * @param  \DateTime $end_time
     * @return void
     */
    public function __construct(int $id, int $meetingPointId, int $instructorId, \DateTime $start_time, \DateTime  $end_time)
    {
        $this->id = $id;
        $this->meetingPointId = $meetingPointId;
        $this->instructorId = $instructorId;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    /**
     * Render HTML
     * @param  Lesson $lesson
     * @return string
     */
    public static function renderHtml(Lesson $lesson): string
    {
        return '<p>' . $lesson->id . '</p>';
    }

    /**
     * Render Text
     * @param  Lesson $lesson
     * @return string
     */
    public static function renderText(Lesson $lesson): string
    {
        return (string) $lesson->id;
    }
}
