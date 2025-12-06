<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Priest;
use App\Models\GalleryItem;
use App\Models\Donation;
use App\Models\ContactSubmission;

class AdminController extends Controller
{
    private function requireAuth(Request $request)
    {
        if (!$request->session()->get('admin_id')) {
            abort(302, '', ['Location' => '/admin/login']);
        }
    }

    public function dashboard(Request $request)
    {
        $this->requireAuth($request);
        return view('admin.home');
    }

    public function announcementsIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = Announcement::latest()->get();
        return view('admin.announcements.index', compact('items'));
    }

    public function announcementsStore(Request $request)
    {
        $this->requireAuth($request);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        Announcement::create($validated);
        return redirect('/admin/announcements')->with('status', 'Announcement created');
    }

    public function announcementsUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Announcement::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $item->update($validated);
        return redirect('/admin/announcements')->with('status', 'Announcement updated');
    }

    public function announcementsDestroy(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Announcement::findOrFail($id);
        $item->delete();
        return redirect('/admin/announcements')->with('status', 'Announcement deleted');
    }

    public function priestsIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = Priest::latest()->get();
        return view('admin.priests.index', compact('items'));
    }

    public function priestsStore(Request $request)
    {
        $this->requireAuth($request);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        Priest::create($validated);
        return redirect('/admin/priest')->with('status', 'Priest created');
    }

    public function priestsUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Priest::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $item->update($validated);
        return redirect('/admin/priest')->with('status', 'Priest updated');
    }

    public function priestsDestroy(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Priest::findOrFail($id);
        $item->delete();
        return redirect('/admin/priest')->with('status', 'Priest deleted');
    }

    public function galleryIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = GalleryItem::latest()->get();
        return view('admin.gallery.index', compact('items'));
    }

    public function galleryStore(Request $request)
    {
        $this->requireAuth($request);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);
        GalleryItem::create($validated);
        return redirect('/admin/gallery')->with('status', 'Image added');
    }

    public function galleryUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = GalleryItem::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);
        $item->update($validated);
        return redirect('/admin/gallery')->with('status', 'Image updated');
    }

    public function galleryDestroy(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = GalleryItem::findOrFail($id);
        $item->delete();
        return redirect('/admin/gallery')->with('status', 'Image deleted');
    }

    public function donationsIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = Donation::latest()->get();
        return view('admin.donations.index', compact('items'));
    }

    public function inquiriesIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = ContactSubmission::latest()->get();
        return view('admin.inquiries.index', compact('items'));
    }
}

