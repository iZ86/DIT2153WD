<?php if (isset($_SESSION['successMessage'])): ?>
    <div id="toast-success" class="toast" role="alert">
        <div class="flex items-center w-full max-w-full p-4 mb-4 text-white rounded-lg shadow bg-indigo-500">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-indigo-500 bg-white rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div style="white-space: nowrap;" class="ms-2 px-2 text-base font-normal"><?php echo $_SESSION['successMessage']; ?></div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-indigo-500 text-white hover:text-indigo-600 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-indigo-600 inline-flex items-center justify-center h-8 w-8" aria-label="Close" onclick="removeToast()">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </div>

    <style>
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            z-index: 1000;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast-success');
            toast.classList.add('show');

            setTimeout(() => {
                removeToast();
            }, 3000);
        });

        function removeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }
    </script>

    <?php unset($_SESSION['successMessage']);?>
<?php endif; ?>
