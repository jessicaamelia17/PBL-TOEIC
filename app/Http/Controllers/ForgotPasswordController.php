<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $mahasiswa = Mahasiswa::where('email', $request->email)->first();

        if (!$mahasiswa) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        // Generate token
        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Kirim email dengan PHPMailer
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));
        $subject = 'Reset Password Akun TOEIC';
        $body = "
    <h2>Reset Password TOEIC</h2>
    <p>Halo,</p>
    <p>Kami menerima permintaan untuk mereset password akun Anda.</p>
    <p>
        Klik tombol di bawah ini untuk mengatur ulang password Anda:
    </p>
    <p>
        <a href='$resetLink' style='
            display:inline-block;
            padding:10px 20px;
            background:#2563eb;
            color:#fff;
            border-radius:5px;
            text-decoration:none;
            font-weight:bold;
        '>Reset Password</a>
    </p>
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
    <hr>
    <small>TOEIC Portal</small>
";

        // PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pengelolaptc02@gmail.com';
            $mail->Password = 'kikfcghwvvqaxesx';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('fachryakbarbagask87@gmail.com', 'TOEIC Portal');
            $mail->addAddress($request->email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
        } catch (Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email: ' . $mail->ErrorInfo]);
        }

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }

    public function showResetForm($token, Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Token reset tidak valid atau sudah kadaluarsa.']);
        }

        $mahasiswa = Mahasiswa::where('email', $request->email)->first();
        if (!$mahasiswa) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
    }
}
