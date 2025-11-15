<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactMailRequest;
use App\Mail\ContactMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * GET /api/contact
     * Chỉ trả thông tin cấu hình hoặc empty, nếu frontend cần hiển thị form.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => [
                'site_email' => config('settings.site_email')
            ]
        ]);
    }

    /**
     * POST /api/contact/send
     */
    public function sendMail(ContactMailRequest $request): JsonResponse
    {
        Mail::to(config('settings.site_email'))->send(
            new ContactMail(
                $request->name,
                $request->email,
                $request->subject,
                $request->message
            )
        );

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully'
        ]);
    }
}
