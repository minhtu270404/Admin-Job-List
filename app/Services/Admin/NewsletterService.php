<?php

namespace App\Services\Admin;

use App\Mail\NewsletterMail;
use App\Models\Subscribers;
use Illuminate\Support\Facades\Mail;
use App\Services\Notify;
use Exception;

class NewsletterService
{
    /**
     * Gửi email newsletter cho tất cả subscribers
     */
    public function sendNewsletter(string $subject, string $message): void
    {
        $subscribers = Subscribers::select('email')->get();

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewsletterMail($subject, $message));
            } catch (Exception $e) {
                logger()->error("Newsletter send failed to {$subscriber->email}: " . $e->getMessage());
            }
        }

        Notify::successNotification('Gửi newsletter thành công!');
    }

    /**
     * Xoá subscriber
     */
    public function deleteSubscriber(string $id): void
    {
        $subscriber = Subscribers::findOrFail($id);
        $subscriber->delete();

        Notify::deletedNotification('Xóa Thành Công');
    }
}
