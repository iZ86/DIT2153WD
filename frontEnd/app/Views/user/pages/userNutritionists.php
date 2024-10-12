<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-white-bg">
    <?php require_once 'components/navBar.php' ?>
    
    <div class="flex flex-col items-center justify-center">
        <h1 class="mt-12 text-4xl font-bold text-[#02463E] font-montserrat">Meet Our Nutritionists</h1>

        <div class="flex items-center justify-center gap-x-10 mt-10">
            <img class="w-3/4 h-72" src="../../public/images/nutrition_header.png" alt="Nutrition.png">
            <div class="border border-[#666666] border-solid h-[17rem]"></div>
            <div class="flex flex-col">
                <p class="font-bold text-[#00796B] font-montserrat text-xl">Why do you need a Nutritionists?</p>
                <br>
                <p class="text-sm text-[#00796B] font-montserrat w-96 leading-6">A nutritionist is essential for creating personalized diet plans that support fitness goals,
                     prevent chronic diseases, and educate individuals on healthier food choices. They help 
                     manage special dietary needs, promote overall well-being, and ensure proper nutrition 
                     complements exercise for better results. In a fitness center, a nutritionist is key to 
                     achieving balanced health and optimal performance.</p>
            </div>
        </div>

        <div class="bg-white mt-32 flex w-full items-center justify-center">
            <div class="my-20 w-1/2 flex flex-col items-center justify-center border border-black border-solid rounded-xl py-14">
                <h1 class="font-bold text-2xl">Make a Reservation Now</h1>

                <form class="flex flex-col gap-y-4" action="" method="GET">
                    <div>
                    <label for="nutritionist">Nutritionist:</label><br>
                    <select class="w-64 border-b-[1px] border-b-black border-solid" name="nutritionist" id="nutritionist" placeholder="SELECT NUTRTIONIST">
                        <option value="" disabled selected>SELECT NUTRITIONIST</option>
                    </select> 
                    </div>

                    <div>
                    <label for="date">Date:</label><br>
                    <select class="w-64 border-b-[1px] border-b-black border-solid" name="date" id="date" placeholder="SELECT DATE">
                        <option value="" disabled selected>SELECT DATE</option>
                    </select> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>