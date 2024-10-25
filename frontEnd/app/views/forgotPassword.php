<?php include '../components/header.php'; ?>
<?php include '../components/navbarLoggedOut.php'; ?>


<section class="p-6 space-y-6 bg-indigo-50 h-screen">
    <div class="">
        <h2 class="text-2xl font-bold mx-auto" style="width: 500px">Forgot Password</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto mx-auto flex flex-col items-center" style="width: 500px;">
        <div class="flex flex-col pb-4">
            <p class="w-fit mb-4">Email</p>
            <input type="text" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
            <p class="w-fit mb-4">Code</p>
            <div class="flex flex-row mb-6">
                <input type="text" class="bg-slate-100 rounded py-1 px-2">
                <input type="submit" value="Submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 ml-2">
            </div>
            <a class="underline text-center text-slate-700 text-md" href="">Request again in 10 seconds</a>
        </div>
    </div>

</section>