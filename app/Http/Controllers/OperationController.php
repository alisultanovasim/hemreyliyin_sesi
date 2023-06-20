<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class OperationController extends Controller
{
    public function setInfo(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => ['required', Rule::in([0, 1])],
            'phone' => [
                'required',
                'string',
                'regex:/^(\+994|0)(50|51|55|70|77)(\d{7})$/'
            ],
        ]);

        $name = $validatedData['name'];
        $surname = $validatedData['surname'];
        $birthday = $validatedData['birthday'];
        $gender = $validatedData['gender'];

        User::query()
            ->wherePhone($validatedData['phone'])
            ->update([
                'name' => $name,
                'surname' => $surname,
                'birthday' => $birthday,
                'gender' => $gender,
            ]);

        return response()->json([
            'message' => 'İstifadəçi məlumatı uğurla yadda saxlanıldı.',
            'status' => 'success',
        ], Response::HTTP_CREATED);
    }

    /**
     * @throws ValidationException
     */
    public function setVoice(Request $request)
    {
        $this->validate($request, [
            'voice' => 'required|file|mimes:aac,flac,m4a,mp2,mp3,ogg,opus,wav,wma'
        ]);
        //flac,mp2,m4a,opus,wav,wma
//        dd($request->file('voice'));

        $voiceFile = $request->file('voice');
        $filename = uniqid() . '.' . $voiceFile->getClientOriginalExtension();
        Storage::disk('public')->put($filename, file_get_contents($voiceFile));


        $voiceModel = new Voice();
        $voiceModel->voice = $voiceFile;
        $user = auth()->user();
        $user->voice()->save($voiceModel);

        return response()->json(['message' => 'Səs qeydə alınıb və uğurla saxlanılıb', 'status' => 'success']);

    }


    public function deleteUser(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required'
        ]);

        $user = User::where('phone', '+994775574510')->first();

        if ($user) {
            PersonalAccessToken::where('tokenable_id', $user->id)->delete();
            $user->delete();

            if (Auth::user() && Auth::user()->id === $user->id) {
                Auth::logout();
            }

            return response()->json(['status' => 'success', 'message' => 'Record deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }
    }
    public function userInfo()
    {
        return response()->json(['status'=>'success','data'=>Auth::user()],Response::HTTP_OK);
    }

    public function updateInfo(Request $request)
    {
        $this->validate($request,[
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'gender' => ['nullable', Rule::in([0, 1])],
            'phone' => [
                'required',
                'string',
                'regex:/^(\+994|0)(50|51|55|70|77)(\d{7})$/'
            ],
        ]);

//        dd($request->name);

        User::query()
            ->where('phone', Auth::user()->phone)
            ->when([$request->has('name'), function ($query) use ($request) {
                return $query->update(['name' => $request->name]);
            },
                $request->has('surname'), function ($query) use ($request) {
                    return $query->update(['surname' => $request->surname]);
                },
                $request->has('birthday'), function ($query) use ($request) {
                    return $query->update(['birthday' => $request->birthday]);
                },
                $request->has('gender'), function ($query) use ($request) {
                    return $query->update(['gender' => $request->gender]);
                }
            ]);

        return response()->json(['status'=>'success','message'=>'Məlumatlar uğurla yeniləndi.'],Response::HTTP_OK);
    }
}
