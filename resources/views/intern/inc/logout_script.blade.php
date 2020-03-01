@if(auth()->check())
    <script>
        const buttonLogout = document.querySelector('#logout-btn');
    
        const submitLogout = async (e) => {
            e.preventDefault();
            const response = await fetch('{{ route('logout') }}');
    
            const data = await response.json();

            if (response.ok) {
            	window.location = data.redirect;
            }

            return;
        }
    
        buttonLogout.addEventListener('click', submitLogout);
  </script>
@endif
