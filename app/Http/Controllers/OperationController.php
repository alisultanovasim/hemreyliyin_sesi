<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ],Response::HTTP_CREATED);
    }

    public function setVoice(Request $request)
    {
        dd(Auth::user());
        $this->validate($request,[
           'voice' => 'required'
        ]);
        $voice = $request->file('voice');
        $base64Voice = base64_encode(file_get_contents($voice->getRealPath()));

        $voiceModel = new Voice();
        $voiceModel->voice = $base64Voice;
        $user = Auth::user();
        $user->voice()->save($voiceModel);

        return response()->json(['message' => 'Səs qeydə alınıb və uğurla saxlanılıb','status'=>'success']);

    }
}
