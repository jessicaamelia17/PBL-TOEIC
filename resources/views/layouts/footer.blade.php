<footer class="bg-blue-600 text-white py-8 mt-12 rounded-t-lg">
    <div class="flex justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
    </div>
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 text-sm gap-6 text-center md:text-left">
        <div>
            <h2 class="font-bold mb-2">Layanan TOEIC</h2>
            <p>Politeknik Negeri Malang<br>Jl. Soekarno - Hatta No.9,<br>Jatimulyo, Lowokwaru, Kota Malang</p>
        </div>
        <div>
            <h2 class="font-bold mb-2">Jam Operasional</h2>
            <p>Senin - Jumat: 08.00 - 16.00 WIB<br>Sabtu - Minggu: Libur</p>
        </div>
        <div>
            <h2 class="font-bold mb-2">Media Sosial</h2>
            <div class="flex justify-center md:justify-start gap-4 text-xl mt-2">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fas fa-globe"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </div>
    <div class="border-t border-white mt-6 pt-4 text-center text-sm">
        <p>Copyright &copy; {{ date('Y') }} TOEIC</p>
    </div>
</footer>
