<!-- resources/views/components/navigation.blade.php -->
<nav class="bg-indigo-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="nav-links ml-auto flex space-x-10"> <!-- Use a custom class for spacing -->
            <a href="{{ route('login') }}" class="text-white hover:text-indigo-300">Login</a>
            <a href="{{ route('register') }}" class="text-white hover:text-indigo-300">Register</a>
            
            <!-- Using JavaScript to create a POST request from a link -->
            <!-- <a href="{{ route('logout') }}" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white hover:text-indigo-300">
            Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> -->
        </div>
    </div>
</nav>
    
