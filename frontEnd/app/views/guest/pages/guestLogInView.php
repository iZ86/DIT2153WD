<?php 

class GuestLogInView {
    /** Constructor for the object. */
    public function __construction() {

    }
}

?>



<section class="p-6 space-y-6 bg-indigo-50 h-screen">
    <div class="">
        <h2 class="text-2xl font-bold mx-auto" style="width: 600px">Login</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto mx-auto flex flex-col items-center" style="height: 500px; width: 600px;">
        <div class="flex flex-col">
            <p class="w-fit mb-4 mt-12">Username</p>
            <input type="text" id="username" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
            <p class="w-fit mb-4">Password</p>
            <input type="password" id="password" class="bg-slate-100 w-72 rounded py-1 px-2 mb-14">
            <div class="flex flex-row space-x-2 mb-4 mx-auto text-slate-700">
                <input type="checkbox">
                <p>keep me logged in</p>
            </div>
            <input type="submit" value="Log In" class="mb-6 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 w-40 mx-auto">
            <a href="signup.php" class="underline mb-2 text-center text-slate-700">Dont have an account? Sign Up</a>
            <a href="forgotPassword.php" class="underline text-center text-slate-700">Forgot Password</a>
        </div>
    </div>

</section>