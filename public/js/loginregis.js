const switchers = [...document.querySelectorAll('.switcher')]

switchers.forEach(item => {
	item.addEventListener('click', function() {
		switchers.forEach(item => item.parentElement.classList.remove('is-active'))
		this.parentElement.classList.add('is-active')
	})
})
function togglePassword() {
  const passFields = document.querySelectorAll('.pass-key');
  passFields.forEach(field => {
    if (field.type === "password") {
      field.type = "text";
    } else {
      field.type = "password";
    }
  });

  // Jika mau ganti teks SHOW/HIDE di tombol juga, perlu sedikit modifikasi lebih lanjut
}
