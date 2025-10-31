<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsletterSendRequest;
use App\Services\Admin\NewsletterService;
use App\Traits\Searchable;
use App\Models\Subscribers;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    use Searchable;

    protected NewsletterService $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->middleware(['permission:news letter']);
        $this->newsletterService = $newsletterService;
    }

    /**
     * Hiển thị danh sách subscribers
     */
    public function index(): View
    {
        $query = Subscribers::query();
        $this->search($query, ['email']);
        $subscribers = $query->orderByDesc('id')->paginate(20);

        return view('admin.newsletter.index', compact('subscribers'));
    }

    /**
     * Gửi mail newsletter
     */
    public function sendMail(NewsletterSendRequest $request)
    {
        $this->newsletterService->sendNewsletter($request->subject, $request->message);

        return redirect()->back();
    }

    /**
     * Xoá subscriber
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->newsletterService->deleteSubscriber($id);

            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response()->json(['message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'], 500);
        }
    }
}
