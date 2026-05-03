<?php
  // Check if function exists to prevent fatal errors
  if (function_exists('get_total_request') && isset($con)) {
      $total = get_total_request($con);
  } else {
      $total = 0; // Fallback value
  }
?>

<div class="container mx-auto p-6">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Total Requests -->
    <a href="index.php?page=records" class="block">
      <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-400 flex flex-col items-center justify-center text-center hover:shadow-lg transition duration-200 cursor-pointer">
        
        <div class="bg-blue-100 p-3 rounded-full mb-3">
          <span class="text-2xl">📋</span>
        </div>

        <p class="text-gray-500 font-bold uppercase text-sm tracking-widest">
          Total Records
        </p>
        
        <h2 class="text-5xl font-black text-black-800 mt-2">
          <?php echo htmlspecialchars($total); ?>
        </h2>
        
        <div class="mt-4 h-1.5 w-20 bg-green-600 rounded-full"></div>
      </div>
    </a>

    <!-- New Request -->
    <a href="index.php?page=request" class="block">
      <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-400 flex flex-col items-center justify-center text-center hover:shadow-lg transition duration-200 cursor-pointer">
        
        <div class="bg-green-100 p-3 rounded-full mb-3">
          <span class="text-2xl">➕</span>
        </div>

        <p class="text-black-500 font-bold uppercase text-sm tracking-widest">
          New Ticket Request
        </p>

      </div>
    </a>

  </div>
</div>
      <!--- User Request --->
    <a href="index.php?page=records" class="block">
      <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-400 flex flex-col items-center justify-center text-center hover:shadow-lg transition duration-200 cursor-pointer">
        
        <div class="bg-blue-100 p-3 rounded-full mb-3">
          <span class="text-2xl">🥷</span>
        </div>

        <p class="text-gray-500 font-bold uppercase text-sm tracking-widest">
          User Requested
        </p>
        
        <h2 class="text-5xl font-black text-black-800 mt-2">
          <?php echo htmlspecialchars($total); ?>
        </h2>
        
        <div class="mt-4 h-1.5 w-20 bg-green-600 rounded-full"></div>
      </div>
    </a>