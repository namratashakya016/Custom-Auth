<template>
  <div class="container mx-auto px-4">
    <div class="flex justify-center mt-6">
      <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded-lg">
          <div class="px-4 py-2 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Dashboard Component</h2>
          </div>
          <div class="p-4">
            <!-- Conditionally render content based on user data -->
            <div v-if="user">
              <h1 class="text-2xl font-bold mb-2">Welcome, {{ user.name }}</h1>
              <p class="text-gray-600">Email: {{ user.email }}</p>
            </div>
            <div v-else>
              <p class="text-gray-500">Loading...</p>
            </div>
            <p class="mt-4 text-gray-700">I'm an example component</p>
            <p>{{ error }} </p>

            <div class="">
              <qrcode-stream @init="onInit" @decode="onDecode" class="w-1/2 max-w-4xl mx-auto hidden-camera" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
/* Custom styles to ensure the video fits well */
.qrcode-stream-wrapper {
  width: 40%;
  height: auto;
}
.hidden-camera {
  /* Hide the camera view */
}
</style>
<script setup>
import { ref, onMounted } from 'vue';
import axios from '../axios'; 
import { QrcodeStream } from 'vue3-qrcode-reader';

const user = ref(null);
const error = ref('');
const decodedString = ref('');

// Function to handle QR code initialization
const onInit = async (promise) => {
  try {
    await promise;
  } catch (err) {
    handleCameraError(err);
  }
};

// Function to handle QR code decoding
const onDecode = async (result) => {
  if (!result || !user.value) {
    error.value = 'No data found or user not logged in';
    return;
  }

  console.log('Decoded QR Code:', result);
  decodedString.value = result;

  try {
    const response = await axios.post('/store-qr-code', {
      user_id: user.value.id, 
      data: result
    });
    if (response.status === 201) {
      alert('QR code data stored successfully');
    }
  } catch (err) {
    if (err.response) {
      error.value = `Server Error: ${err.response.data.message || 'Unknown error'}`;
    } else if (err.request) {
      error.value = 'No response from server';
    } else {
      error.value = `Request Error: ${err.message}`;
    }
    console.error('Error storing QR code data:', err);
  }
};


// Function to handle different camera errors
const handleCameraError = (err) => {
  switch (err.name) {
    case 'NotAllowedError':
      error.value = "User denied camera access permission";
      break;
    case 'NotFoundError':
      error.value = "No suitable camera device installed";
      break;
    case 'NotSupportedError':
      error.value = "Page is not served over HTTPS (or localhost)";
      break;
    case 'NotReadableError':
      error.value = "Maybe camera is already in use";
      break;
    case 'OverconstrainedError':
      error.value = "Did you request the front camera although there is none?";
      break;
    case 'StreamApiNotSupportedError':
      error.value = "Browser seems to be lacking features";
      break;
    default:
      error.value = "An unknown error occurred";
  }
};

// Fetch user data
const fetchUserData = async () => {
  try {
    const response = await axios.get('/user');
    user.value = response.data;
  } catch (err) {
    console.error('Error fetching user data:', err);
  }
};

// Fetch user data on component mount
onMounted(() => {
  const token = localStorage.getItem('token');
  if (token) {
    fetchUserData();
  } else {
    console.log('No token found in localStorage.');
  }
});
</script>
