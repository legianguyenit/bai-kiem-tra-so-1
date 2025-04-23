<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-4 md:p-8">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row gap-8">
        <!-- Left Profile Card -->
        <div class="w-full md:w-1/3 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-6 shadow-xl">
            <div class="flex flex-col items-center text-white">
                <img src="https://via.placeholder.com/150" 
                     alt="avatar"
                     class="rounded-full w-40 h-40 border-4 border-white/30 mb-6">
                
                <h2 class="text-2xl font-bold mb-1">John Doe</h2>
                <p class="text-sm opacity-80">Premium Member</p>
                
                <div class="flex gap-4 mt-6 text-white/80">
                    <a href="#" class="hover:text-white transition">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-white transition">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-white transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="w-full md:w-2/3 bg-white rounded-2xl shadow-xl p-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Total Posts</p>
                    <p class="text-2xl font-bold text-blue-600">1,234</p>
                </div>
                <div class="bg-green-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Followers</p>
                    <p class="text-2xl font-bold text-green-600">5,678</p>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="space-y-5">
                <div class="flex items-center justify-between border-b pb-3">
                    <div>
                        <p class="text-sm text-gray-500">User ID</p>
                        <p class="font-medium">#123456</p>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm">
                        Verified
                    </span>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-500">Full Name</label>
                    <p class="font-medium">John Michael Doe</p>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-500">Email</label>
                    <p class="font-medium break-all">john.doe@example.com</p>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-500">Password</label>
                    <div class="flex items-center gap-2">
                        <span class="font-medium">••••••••</span>
                        <button class="text-blue-500 hover:text-blue-700 text-sm">
                            <i class="fas fa-sync-alt"></i> Change
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-500">Joined Date</label>
                    <p class="font-medium">January 15, 2023</p>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-8 flex justify-end">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg 
                           flex items-center gap-2 transition-all">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
            </div>
        </div>
    </div>
</body>
</html>