<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryStoreRequest;
use App\Http\Requests\Admin\CountryUpdateRequest;
use App\Services\Admin\CountryService;
use App\Services\Notify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware(['permission:job locations']);
        $this->countryService = $countryService;
    }

    /**
     * Danh sách quốc gia.
     */
    public function index(): View
    {
        $countries = $this->countryService->getPaginatedCountries();
        return view('admin.location.country.index', compact('countries'));
    }

    /**
     * Form thêm mới quốc gia.
     */
    public function create(): View
    {
        return view('admin.location.country.create');
    }

    public function store(CountryStoreRequest $request)
    {
        try {
            $this->countryService->createCountry($request->validated());
            Notify::createdNotification('Thêm Mới Thành Công');
            return redirect()->route('admin.countries.index');
        } catch (Throwable $e) {
            logger()->error('Lỗi khi tạo quốc gia: '.$e->getMessage(), ['exception' => $e]);
            Notify::errorNotification('Không thể tạo quốc gia, vui lòng thử lại!');
            return redirect()->back()->withInput();
        }
    }

    public function edit(string $id)
    {
        $country = $this->countryService->findCountryById($id);
        return view('admin.location.country.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, string $id)
    {
        try {
            $this->countryService->updateCountry($id, $request->validated());
            Notify::updatedNotification('Cập Nhật Thành Công');
            return redirect()->route('admin.countries.index');
        } catch (Throwable $e) {
            logger()->error('Lỗi khi cập nhật quốc gia: '.$e->getMessage(), ['exception' => $e]);
            Notify::errorNotification('Không thể cập nhật, vui lòng thử lại!');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $result = $this->countryService->deleteCountry($id);

            if (!$result) {
                return response()->json(['message' => 'Không thể xoá vì đang được sử dụng!'], 400);
            }

 Notify::deletedNotification('Xóa Thành Công');            return response()->json(['message' => 'success'], 200);
        } catch (Throwable $e) {
            logger()->error('Lỗi khi xoá quốc gia: '.$e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Đã xảy ra lỗi, vui lòng thử lại!'], 500);
        }
    }
}
