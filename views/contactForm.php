<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
  <div class="max-w-md w-full">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Contact Form</h2>


      <?php $error = $_GET['error'] ?? ''; ?>
      <!-- Error Popup -->
      <div id="error-popup" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 <?= $error ? '' : 'hidden' ?>">
        <div class="flex">
          <button onclick="closeErrorPopup()" class="text-red-500 hover:text-red-700 font-bold text-xl">×</button>
          <div class="ml-3">
            <p id="error-message" class="text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
          </div>
        </div>
      </div>

      <form method="POST" action="/contact-manager2/index.php?action=saveContact" id="contact-form" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required />
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required />
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
          <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required />
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Submit</button>
      </form>
      <a href="/contact-manager2/index.php?action=contactList" class="text-indigo-600 hover:underline mt-8">← View Contact List</a>
    </div>
  </div>

  

</div>
<script>
  function closeErrorPopup() {
    document.getElementById('error-popup').classList.add('hidden');
  }
</script>
</body>
</html>


