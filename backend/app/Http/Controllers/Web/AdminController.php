<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Priest;
use App\Models\GalleryItem;
use App\Models\Donation;
use App\Models\ContactSubmission;
use App\Models\Service;
use App\Models\Schedule;

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
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:5',
        ]);
        Announcement::create($validated);
        return redirect('/admin/announcements')->with('status', 'Announcement created');
    }

    public function announcementsUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Announcement::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:5',
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
            'name' => 'required|string|min:5|max:255',
            'description' => 'nullable|string|min:5',
            'mass_time' => 'required|string',
        ]);
        $file = $request->file('image_file');
        $finalUrl = null;
        if ($file) {
            $request->validate([
                'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);
            $dir = public_path('uploads/priests');
            if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = uniqid('priest_').'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $finalUrl = '/uploads/priests/'.$name;
        }
        Priest::create([
            'name' => $validated['name'],
            'image' => $finalUrl,
            'description' => $validated['description'] ?? null,
        ]);
        $raw = $validated['mass_time'];
        $human = date('g:ia', strtotime($raw));
        Schedule::create([
            'time' => $human ?: $raw,
            'language' => 'Tagalog',
        ]);
        return redirect('/admin/priest')->with('status', 'Priest created');
    }

    public function priestsUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Priest::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'image' => 'nullable|string',
            'description' => 'nullable|string|min:5',
        ]);
        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ];
        $file = $request->file('image_file');
        if ($file) {
            $request->validate([
                'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);
            $dir = public_path('uploads/priests');
            if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = uniqid('priest_').'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $data['image'] = '/uploads/priests/'.$name;
        } else if (!empty($validated['image'])) {
            $data['image'] = $validated['image'];
        }
        $item->update($data);
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
        $validatedTitle = $request->validate([
            'title' => 'required|string|min:5|max:255',
        ]);
        $file = $request->file('image_file');
        $request->validate([
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        $dir = public_path('uploads/gallery');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $name = uniqid('img_').'.'.$file->getClientOriginalExtension();
        $file->move($dir, $name);
        $finalUrl = '/uploads/gallery/'.$name;
        GalleryItem::create(['title' => $validatedTitle['title'], 'url' => $finalUrl]);
        return redirect('/admin/gallery')->with('status', 'Image added');
    }

    public function galleryUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = GalleryItem::findOrFail($id);
        $validatedTitle = $request->validate([
            'title' => 'required|string|min:5|max:255',
        ]);
        $file = $request->file('image_file');
        $request->validate([
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        $dir = public_path('uploads/gallery');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $name = uniqid('img_').'.'.$file->getClientOriginalExtension();
        $file->move($dir, $name);
        $finalUrl = '/uploads/gallery/'.$name;
        $item->update(['title' => $validatedTitle['title'], 'url' => $finalUrl]);
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
        $items = Donation::whereNull('archived_at')->latest()->get();
        $qrPath = file_exists(public_path('uploads/donation_qr.png')) ? '/uploads/donation_qr.png' : null;
        return view('admin.donations.index', compact('items', 'qrPath'));
    }

    public function donationsUpdateQR(Request $request)
    {
        $this->requireAuth($request);
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        $dir = public_path('uploads');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $file = $request->file('qr_image');
        $name = 'donation_qr.png';
        $file->move($dir, $name);
        return redirect('/admin/donations')->with('status', 'Donation QR updated');
    }

    public function inquiriesIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = ContactSubmission::where('archived', false)->latest()->get();
        return view('admin.inquiries.index', compact('items'));
    }

    public function inquiriesArchivePage(Request $request)
    {
        $this->requireAuth($request);
        $items = ContactSubmission::where('archived', true)->latest()->get();
        return view('admin.inquiries.archive', compact('items'));
    }

    public function inquiriesArchive(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = ContactSubmission::findOrFail($id);
        $item->update(['archived' => true]);
        return redirect('/admin/inquiries')->with('status', 'Inquiry archived');
    }

    public function inquiriesUnarchive(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = ContactSubmission::findOrFail($id);
        $item->update(['archived' => false]);
        return redirect('/admin/inquiries/archive')->with('status', 'Inquiry unarchived');
    }

    public function servicesIndex(Request $request)
    {
        $this->requireAuth($request);
        $items = Service::latest()->get();
        return view('admin.services.index', compact('items'));
    }

    public function servicesStore(Request $request)
    {
        $this->requireAuth($request);
        $validated = $request->validate([
            'text' => 'required|string|min:5',
            'image1' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        $dir = public_path('uploads/services');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $file = $request->file('image1');
        $name = uniqid('svc_').'.'.$file->getClientOriginalExtension();
        $file->move($dir, $name);
        $path = '/uploads/services/'.$name;
        $autoName = substr($validated['text'], 0, 60);
        Service::create([
            'name' => $autoName,
            'text' => $validated['text'],
            'image1' => $path,
        ]);
        return redirect('/admin/services')->with('status', 'Service added');
    }

    public function servicesUpdate(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Service::findOrFail($id);
        $validated = $request->validate([
            'text' => 'required|string|min:5',
            'image1' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        $dir = public_path('uploads/services');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $data = [
            'text' => $validated['text'],
        ];
        $file = $request->file('image1');
        if ($file) {
            $name = uniqid('svc_').'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $data['image1'] = '/uploads/services/'.$name;
        }
        $item->update($data);
        return redirect('/admin/services')->with('status', 'Service updated');
    }

    public function servicesDestroy(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Service::findOrFail($id);
        $item->delete();
        return redirect('/admin/services')->with('status', 'Service deleted');
    }

    public function donationsArchivePage(Request $request)
    {
        $this->requireAuth($request);
        $items = Donation::whereNotNull('archived_at')->latest('archived_at')->get();
        return view('admin.donations.archive', compact('items'));
    }

    public function donationsArchive(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Donation::findOrFail($id);
        $item->update([
            'archived_at' => now(),
            'archived_by' => session('admin_name')
        ]);
        return redirect('/admin/donations')->with('status', 'Donation archived');
    }

    public function donationsUnarchive(Request $request, string $id)
    {
        $this->requireAuth($request);
        $item = Donation::findOrFail($id);
        $item->update([
            'archived_at' => null,
            'archived_by' => null,
        ]);
        return redirect('/admin/donations/archive')->with('status', 'Donation unarchived');
    }

    public function search(Request $request)
    {
        $this->requireAuth($request);
        $q = trim((string) $request->query('q'));
        $announcements = Announcement::query()
            ->where('title', 'like', "%$q%")
            ->orWhere('content', 'like', "%$q%")
            ->latest()->take(20)->get();
        $priests = Priest::query()
            ->where('name', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%")
            ->latest()->take(20)->get();
        $gallery = GalleryItem::query()
            ->where('title', 'like', "%$q%")
            ->latest()->take(20)->get();
        $donations = Donation::query()
            ->where('name', 'like', "%$q%")
            ->orWhere('reference_number', 'like', "%$q%")
            ->latest()->take(20)->get();
        $inquiries = ContactSubmission::query()
            ->where('name', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")
            ->orWhere('message', 'like', "%$q%")
            ->latest()->take(20)->get();
        return view('admin.search', compact('q','announcements','priests','gallery','donations','inquiries'));
    }
}
