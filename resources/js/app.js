require('./bootstrap');

// resources/js/app.js

// Ambil URL API backend dari environment variable yang disuntikkan oleh Laravel Mix
// Nilai ini akan diambil dari .env lokal saat dev, dan dari Vercel saat build di Vercel
const backendApiUrl = process.env.MIX_APP_API_URL;

if (backendApiUrl) {
    console.log('Backend API URL:', backendApiUrl);

    // Contoh penggunaan: melakukan panggilan API menggunakan Native Fetch API
    fetch(`${backendApiUrl}/api/data`) // Ganti '/api/data' dengan endpoint API Anda
        .then(response => {
            // Pastikan respons OK (status 200-299)
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            // Parse respons sebagai JSON
            return response.json();
        })
        .then(data => {
            console.log('Data dari backend:', data);
            // Lakukan sesuatu dengan data yang diterima
        })
        .catch(error => {
            console.error('Ada kesalahan saat mengambil data dari backend:', error);
            // Tangani error
        });
} else {
    console.warn('MIX_APP_API_URL tidak terdefinisi. Pastikan diatur di .env atau Vercel Environment Variables.');
}

// ... kode JavaScript lainnya yang ada di app.js Anda
