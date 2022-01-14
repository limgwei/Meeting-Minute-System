<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Datatables\GroupMembersDatatable;
use App\Http\Controllers\Datatables\GroupsDatatable;
use App\Http\Controllers\Group\AgendaController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Group\GroupMemberController;
use App\Http\Controllers\Group\InvitationController;
use App\Http\Controllers\Group\MeetingController;
use App\Http\Controllers\Group\PendingAgendaController;
use App\Http\Controllers\Group\SettingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware(['auth','language'])->group(function () {

    Route::get('/groups/left_group/{group_id}',[GroupController::class,'leftGroup'])->name('groups.leftGroup');
    Route::get('/groups/meeting_schedule',[GroupController::class,'meeting_schedule'])->name('meeting_schedule.meeting_schedule');
    Route::get('/groups/meeting_schedule_action',[GroupController::class,'meeting_schedule_action'])->name('meeting_schedule.meeting_schedule_action');

    Route::get('/notifications',[InvitationController::class,'getNotification'])->name('invitation.notifications');
    Route::get('/invitations',[InvitationController::class,'getInvitation'])->name('invitation.invitation');
    Route::get('/invitation/{id}/{reply}',[InvitationController::class,'getReply'])->name('invitation.reply');
    Route::post('/sendInvitation',[InvitationController::class,'sendInvitation'])->name('invitation.sendInvitation');
    Route::get('/notification/update',[InvitationController::class,'updateSeen'])->name('invitation.updateSeen');

    Route::get('/a',[InvitationController::class,'a']);

    Route::get("/settings",[SettingController::class,'index'])->name('settings.index');
    Route::get("/settings/edit-profile",[SettingController::class,'editProfile'])->name('settings.editProfile');
    Route::post("/settings/update-profile",[SettingController::class,'updateProfile'])->name('settings.updateProfile');
    Route::post('/settings/change-language',[SettingController::class,'changeLanguage'])->name('settings.changeLanguage');

    Route::get("/groups/Datatable", [GroupsDatatable::class, 'index'])->name('groupsDatatable');
    Route::get("/groups/delete/{id}", [GroupController::class, 'destroy'])->name('groups.delete');
    Route::resource('groups', GroupController::class)->name('*', 'groups');
    Route::get("/groups/{id}/change", [GroupController::class, 'changePassword'])->name('groups.changePassword');
    Route::post("groups/join-group", [GroupController::class, 'joinGroup'])->name("groups.joinGroup");
    Route::get("groups/members/{id}", [GroupController::class, 'members'])->name("groups.members");

    Route::get("/groups/groupMemberDatatable/{id}", [GroupMembersDatatable::class, 'index'])->name('groupsMember.Datatable');
    Route::get("/groups/setAdmin/{member_id}/{group_id}", [GroupMemberController::class, 'setAdmin'])->name('groupsMember.setAdmin');
    Route::get("/groups/deleteMember/{member_id}/{group_id}", [GroupMemberController::class, 'deleteMember'])->name('groupsMember.deleteMember');
    Route::get('/groups/editPosition/{member_id}/{group_id}', [GroupMemberController::class, "editPosition"])->name('groupsMember.editPosition');
    Route::post('/groups/updatePosition', [GroupMemberController::class, "updatePosition"])->name('groupsMember.updatePosition');

    Route::get("groupsss/ddd", [GroupController::class, "ddd"])->name("groups.ddd");


    Route::get('/linkstorage', function () {
        Artisan::call('storage:link');
    });

    // Route::resource('meetings', MeetingController::class)->name('*', 'meetings');
    Route::get('/meetings/view/{id}', [MeetingController::class, 'show'])->name('meetings.show');
    Route::get('/meetings/edit/{id}', [MeetingController::class, 'edit'])->name('meetings.edit');
    Route::get('meetings/create/{group_id}', [MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/meetings/store/', [MeetingController::class, "store"])->name('meetings.store');
    Route::post('/meetings/update/', [MeetingController::class, "update"])->name('meetings.update');
    Route::get('/meetings/exportPDF/{id}', [MeetingController::class, "exportPDF"])->name('meetings.exportPDF');
    Route::post('/meetings/checkAttendance', [MeetingController::class, "checkAttendance"])->name('meetings.checkAttendance');

    Route::resource('agendas', AgendaController::class)->name('*', 'agendas');
    Route::post('/agendas/changeTitle/{id}', [AgendaController::class, "changeTitle"])->name('agendas.changeTitle');

    Route::get('/pending_agenda/{group_id}', [PendingAgendaController::class, "index"])->name('pending_agendas.index');
    Route::get('/pending_agenda/view/{agenda_id}', [PendingAgendaController::class, "view"])->name('pending_agendas.view');
    Route::get('/pending_agenda/add/{group_id}', [PendingAgendaController::class, "add"])->name('pending_agendas.add');
    Route::post('/pending_agenda/store', [PendingAgendaController::class, "store"])->name('pending_agendas.store');
    Route::post('/pending_agenda/update', [PendingAgendaController::class, "update"])->name('pending_agendas.update');
    // Route::get('/group', [ViewGroupController::class, 'groups'])->name('group');
});
