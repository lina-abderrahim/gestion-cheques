<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications=Notification::latest()->paginate(10);
        return view('notifications.index',compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read'=>true]);
        return back()->with('success','Notification marquée comme lue');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success','Notification supprimé');
    }

    public function markAllAsRead()
{
    Notification::where('is_read', false)->update(['is_read' => true]);

    return redirect()->back();
}
   public function markAsUnread(Notification $notification)
{
    $notification->is_read = false;
    $notification->save();

    return redirect()->back();
}


}