<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class DTNotifyUser extends Notification
{
    use Queueable;

    public $info;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->level("success")
            ->subject("Mathematics Diagnostic Test Report")
            ->with(new HtmlString("<p style='color: black'>Dear Parents,</p>"))
            ->with("")
            ->with(new HtmlString("<p style='color: black'>Thank you for taking the time to have your child complete the diagnostic test for our maths class. The results of this test will allow us to better understand your child's current level of understanding in maths and develop a plan to help them reach their full potential.</p>"))
            ->with("")
            ->with(new HtmlString("<p style='color: black'>We understand that maths can be a challenging subject, but we want to assure you that our goal is to make the learning process as enjoyable and engaging as possible for your child. Our team of experienced educators is dedicated to creating a supportive and nurturing environment that will encourage your child to develop their maths skills and improve their confidence.</p>"))
            ->with("")
            ->with(new HtmlString("<p style='color: black'>We believe that with the right guidance and support, every student can excel in maths. As we move forward, we will keep you informed of your child's progress and work together to help them reach their academic goals.</p>"))
            ->with("")
            ->with(new HtmlString("<p style='color: black'>Thank you for your continued support and involvement in your child's education. If you have any questions or concerns, please do not hesitate to reach out to us.</p>"))
            ->action('View Report', route('diagnostic_test.report', $this->info['result_id']))
            ->salutation(new HtmlString("<p style='color: dimgrey'>Regards,<br>ALFA and Friends Centre</p>"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
