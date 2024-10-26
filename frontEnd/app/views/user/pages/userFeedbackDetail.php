<?php include __DIR__ .  '/../components/userHeader.php'; ?>
<?php include __DIR__ .  '/../components/userNavbar.php'; ?>

<section class="p-6 space-y-6 bg-indigo-50">
    <!-- Top Buttons -->
    <div class="mx-4">
        <div class="flex items-center justify-between w-3/5 mx-auto">
            <h2 class="text-2xl font-bold">Feedbacks</h2>
            <div class="flex items-center space-x-4">
                <button id="closeFeedbackButton" class="bg-green-400 hover:bg-green-500 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                    <i class="bx bxs-plus-circle"></i>
                    <span>Close</span>
                </button>
                <button id="deleteFeedbackButton" class="bg-red-400 hover:bg-red-500 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                    <i class="bx bxs-plus-circle"></i>
                    <span>Delete</span>
                </button>
            </div>
        </div>
    </div>

    <!-- White Section -->
    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto flex flex-row w-3/5 mx-auto" style="height:800px;">
        <div class="w-96 justify-between flex flex-col">
            <div class="flex flex-col bg-indigo-500 rounded-lg p-3 mr-6 text-white">
                <p id="feedbackTitle" class="text-lg font-medium">Issue with sink in female restroom, need urgent fix, it's disgusting</p>
                <div class="flex flex-row mt-3 justify-between">
                    <p id="feedbackStatus" class="rounded-full text-sm px-2 bg-white text-indigo-500">Open</p>
                    <i class="bx bxs-edit mt-1"></i>
                </div>
            </div>
            <div class="flex flex-row space-x-4">
                <div class="flex flex-col font-medium">
                    <p>No</p>
                    <p>Date</p>
                    <p>Time</p>
                    <p>UID</p>
                </div>
                <div class="flex flex-col">
                    <p id="feedbackNo">000</p>
                    <p id="feedbackDate">00/00/00</p>
                    <p id="feedbackTime">00:00</p>
                    <p id="feedbackUID">000</p>
                </div>
            </div>
        </div>
        <div class="w-full p-6 border-l-2 overflow-x-auto flex flex-col">
            <div class="feedbackMessageDate text-sm text-center mb-2 text-gray-400">
                00/00/00
            </div>
            <div class="feedbackMessage flex flex-row">
                <div class="feedbackMessageProfile mr-4 self-center text-2xl text-black-500">
                    <i class="bx bxs-user"></i>
                </div>
                <div class="feedbackMessageContent w-full bg-gray-200 p-3 rounded-lg mr-2 text-gray-600">
                    The sink so ugly
                </div>
                <div class="feedbackMessageTime self-end text-sm text-gray-400">
                    00:00
                </div>
            </div>
            <div class="flex flex-row mt-auto">
                <div class="enterFeedbackMessage ml-10 w-full">
                    <input type="text" id="feedbackMessage" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Type here...">
                </div>
                <button id="sendFeedbackMessage" class="text-indigo-500 text-xl font-medium ml-5 rounded-lg self-center">
                    <i class="bx bxs-send"></i>
                </button>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ .  '/../components/userFooter.php'; ?>