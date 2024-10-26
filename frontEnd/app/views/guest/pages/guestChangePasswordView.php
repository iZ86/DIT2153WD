<?php include __DIR__ .  '/../components/guestHeader.php'; ?>
<?php include __DIR__ .  '/../components/guestNavbar.php'; ?>


<section class="p-6 space-y-6 bg-indigo-50 pb-72">
    <div class="">
        <h2 class="text-2xl font-bold mx-auto" style="width: 500px">Change Password</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto mx-auto flex flex-col items-center" style="width: 500px;">
        <div class="flex flex-col">
            <p class="w-fit mb-4">New Password</p>
            <input type="password" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
            <p class="w-fit mb-4">Repeat Password</p>
            <input type="password" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
            <input type="submit" value="Change Password" class="mb-6 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 w-40 mx-auto">
        </div>
    </div>

</section>

<?php include __DIR__ .  '/../components/guestFooter.php'; ?>