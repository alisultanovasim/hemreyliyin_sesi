<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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

    public function setVoice(Request $request)
    {
        $this->validate($request, [
            'voice' => 'required|file|mimes:aac,flac,m4a,mp2,mp3,ogg,opus,wav,wma'
        ]);

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
        $this->validate($request,[
           'phone'=>'required'
        ]);
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'Record deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

    }
}
