<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto AIK</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            color: #fff;
        }

        header {
            text-align: center;
            padding-top: 40px;
            padding-bottom: 20px;
        }

        .gallery {
            max-width: 1600px;
            margin: auto;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        /* CARD */
        .card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            background: #020617;
            cursor: pointer;
            height: 360px;
            opacity: 0;
            transform: translateY(80px) scale(.85);
            transition: opacity .7s ease, transform .8s cubic-bezier(.18, .89, .32, 1.28), box-shadow .3s ease;
        }

        .card.show {
            opacity: 1;
            transform: none;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 25px 60px rgba(0, 0, 0, .45);
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .45s cubic-bezier(.22, 1, .36, 1);
        }

        .card:hover img {
            transform: scale(1.12);
        }

        /* HOVER OVERLAY */
        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .7), transparent);
            padding: 10px;
            opacity: 0;
            transition: .35s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* anchor content to bottom */
            align-items: flex-start;
            gap: 4px; /* smaller gap between lines */
            pointer-events: none; /* allow clicks to pass to the card */
        }

        .card:hover .overlay {
            opacity: 1;
        }

        .overlay h3 {
            font-size: 16px;
            margin: 0;
            line-height: 1; /* tighten line height */
            pointer-events: auto; /* make text selectable/clickable if needed */
        }

        .overlay p, span {
            font-size: 10px;
            opacity: .7;
            margin: 0;
            line-height: 1; /* tighten line height */
            pointer-events: auto;
        }

        .overlay .date {
            font-size: 10px;
            opacity: .7;
            margin: 0;
            line-height: 1;
        }

        /* MODAL */
        #modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        #modal.show {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            max-width: 95vw;
            max-height: 90vh;
            width: 95vw;
            height: 90vh;
            background: #111827;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
            transform: scale(0.7);
            opacity: 0;
            transition: transform 0.3s cubic-bezier(.22, 1, .36, 1), opacity 0.3s ease;
        }

        #modal.show .modal-box {
            transform: scale(1);
            opacity: 1;
        }

        .modal-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            cursor: grab;
            user-select: none;
            -webkit-user-drag: none;
            transition: transform .2s ease;
        }

        .modal-info {
            position: absolute;
            bottom: 0;
            padding: 16px;
            background: transparent;
            /* background: linear-gradient(to top, rgba(0, 0, 0, .7), transparent); */
        }

        .modal-info h2 {
            margin-bottom: 4px;
            font-size: 18px;
        }

        .modal-info p, span {
            opacity: .7;
            margin-bottom: 2px;
            font-size: 14px;
        }

        .modal-info .date {
            opacity: .5;
            font-size: 14px;
        }

        /* CLOSE BUTTON */
        .close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background:red;
            color: #fff;
            font-size: 24px;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .3s ease;
            z-index: 10;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

       /* RESPONSIVE */
        @media (max-width: 1200px) {
            .gallery {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .gallery {
                grid-template-columns: repeat(3, 1fr); /* tablet & HP landscape */
            }
        }

        @media (max-width: 600px) {
            .gallery {
                grid-template-columns: repeat(3, 1fr); /* HP portrait */
                gap: 10px; /* biar tidak terlalu rapat */
            }

            .card {
                height: 180px; /* lebih pendek agar proporsional */
                border-radius: 12px;
            }

            .overlay h3 {
                font-size: 12px;
            }

            .overlay p,
            .overlay span {
                font-size: 9px;
            }
        }

        @media (max-width: 400px) {
            .gallery {
                grid-template-columns: repeat(3, 1fr); /* HP kecil tetap 4 */
                gap: 4px;
            }

            .card {
                height: 150px;
            }
        }

    </style>
</head>

<body>

    <div class="d-flex justify-content-end">
        <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </div>
    <header>
        <h2 style="color:#000">Galeri Foto AIK</h2>
    </header>
    <section class="gallery" id="gallery"></section>
    <!-- MODAL -->
    <div id="modal">
        <div class="modal-box">
            <button class="close-btn" id="closeModal">&times;</button>
            <img id="modalImg">
            <div class="modal-info">
                <h2 id="modalTitle"></h2>
                <!-- <p id="modalUnit"></p> -->
                <p id="kegiatan"></p>
                <p id="nama_aktivitas"></p>
                <p id="modalDesc"></p>
                <p class="date" id="modalDate"></p>
            </div>
        </div>
    </div>

    <script>
        let page = 1, loading = false, done = false;
        const gallery = document.getElementById("gallery");
        const modal = document.getElementById("modal");
        const modalImg = document.getElementById("modalImg");
        const modalTitle = document.getElementById("modalTitle");
        // const modalUnit = document.getElementById("modalUnit");
        const modalDesc = document.getElementById("modalDesc");
        const modalDate = document.getElementById("modalDate");
        const modalKegiatan = document.getElementById("kegiatan");
        const closeBtn = document.getElementById("closeModal");
        const modalBox = document.querySelector(".modal-box");
        const modalNama_aktivitas = document.getElementById("nama_aktivitas");

        // --- Zoom & Drag Variables ---
        let scale = 1;
        const scaleStep = 0.1;
        const scaleMax = 3;
        const scaleMin = 1;
        let isDragging = false;
        let startX = 0, startY = 0;
        let currentX = 0, currentY = 0;

        // --- Load photos dari API ---
        function loadMore() {
            if (loading || done) return;
            loading = true;

            const params = new URLSearchParams(window.location.search);
            const id = params.get("id");

            fetch(`galery/photo?page=${page}&idUser=${id}`)
                .then(r => r.json())
                .then(res => {
                    if (!res.data || res.data.length === 0) { done = true; return; }

                    res.data.forEach((p, i) => {
                        const card = document.createElement("div");
                        card.className = "card";

                        const img = document.createElement("img");
                        img.src = p.url;

                        const overlay = document.createElement("div");
                        overlay.className = "overlay";
                        overlay.innerHTML += `<h3>${p.title ? p.title : ''} <span>${p.unit ? '(' + p.unit + ')' : ''}</span> </h3>`;
                        overlay.innerHTML += `<p>${p.kegiatan ? p.kegiatan : ''}${p.subkegiatan ? ' - ' + p.subkegiatan : ''}</p>`;
                        overlay.innerHTML += `<p>${p.nama_aktivitas ? p.nama_aktivitas : ''}</p>`;
                        overlay.innerHTML += `<p>${p.description ? p.description : ''}</p>`;
                        overlay.innerHTML += `<p class="date">${formatDateID(p.date)}</p>`;

                        card.onclick = () => openModal(p);
                        card.appendChild(img);
                        card.appendChild(overlay);
                        gallery.appendChild(card);

                        setTimeout(() => card.classList.add("show"), i * 80);
                    });
                    page++;
                    loading = false;
                }).catch(err => { console.error("Error:", err); loading = false; });
        }

        // --- Open Modal ---
        function openModal(p) {
            modal.classList.add("show");
            modalImg.src = p.url;
            modalDate.innerText = formatDateID(p.date);
            // Safely render title + unit (unit wrapped in a span). Use escapeHtml to avoid XSS.
            modalTitle.innerHTML = escapeHtml(p.title ? p.title : '') + (p.unit ? " <span>(" + escapeHtml(p.unit) + ")</span>" : "");
            // modalUnit.innerText = p.unit;
            modalDesc.innerText = p.description;
            modalNama_aktivitas.innerText = p.nama_aktivitas;
            modalKegiatan.innerText = p.kegiatan + (p.subkegiatan ? " - " + p.subkegiatan : "");

            // Reset transform
            scale = 1; currentX = 0; currentY = 0;
            modalImg.style.transform = "translate(0px,0px) scale(1)";

            // Set modalImg full size (fit modal)
            modalImg.style.width = "100%";
            modalImg.style.height = "100%";
            modalImg.style.objectFit = "contain";
        }

        // --- Close Modal ---
        function closeModalFunc() {
            modal.classList.remove("show");
            setTimeout(() => {
                modalImg.src = "";
                modalTitle.innerHTML = "";
                modalDesc.innerText = "";
                modalDate.innerText = "";
                modalKegiatan.innerText = "";
                scale = 1; currentX = 0; currentY = 0;
                modalImg.style.transform = "translate(0px,0px) scale(1)";
            }, 300);
        }
        closeBtn.onclick = closeModalFunc;
        modal.onclick = (e) => { if (e.target === modal) closeModalFunc(); };

        // --- Zoom dengan mouse wheel ---
        modalImg.addEventListener("wheel", e => {
            e.preventDefault();
            let prevScale = scale;
            if (e.deltaY < 0) { scale = Math.min(scale + scaleStep, scaleMax); }
            else { scale = Math.max(scale - scaleStep, scaleMin); }

            // Reset currentX/currentY jika scale === 1
            if (scale === 1) {
                currentX = 0;
                currentY = 0;
            } else {
                // Pastikan posisi tidak keluar modal
                currentX = clamp(currentX, -(modalImg.offsetWidth * (scale - 1) / 2), (modalImg.offsetWidth * (scale - 1) / 2));
                currentY = clamp(currentY, -(modalImg.offsetHeight * (scale - 1) / 2), (modalImg.offsetHeight * (scale - 1) / 2));
            }

            updateTransform();
        });

        // --- Drag foto ---
        modalImg.addEventListener("mousedown", e => {
            if (scale <= 1) return; // tidak bisa drag saat zoom = 1
            isDragging = true;
            startX = e.clientX - currentX;
            startY = e.clientY - currentY;
            modalImg.style.cursor = "grabbing";
        });
        window.addEventListener("mousemove", e => {
            if (!isDragging) return;
            currentX = e.clientX - startX;
            currentY = e.clientY - startY;

            // batas kiri/kanan atas/bawah
            const maxX = (modalImg.offsetWidth * (scale - 1)) / 2;
            const maxY = (modalImg.offsetHeight * (scale - 1)) / 2;
            currentX = clamp(currentX, -maxX, maxX);
            currentY = clamp(currentY, -maxY, maxY);

            updateTransform();
        });
        window.addEventListener("mouseup", e => {
            isDragging = false;
            modalImg.style.cursor = "grab";
        });

        // --- Update Transform ---
        function updateTransform() {
            modalImg.style.transform = `translate(${currentX}px, ${currentY}px) scale(${scale})`;
        }

        // --- Helper: clamp ---
        function clamp(val, min, max) {
            return Math.min(Math.max(val, min), max);
        }

        // --- Helper: escapeHtml --- (prevent HTML injection)
        function escapeHtml(str) {
            if (str === undefined || str === null) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        // --- Format tanggal ke Indonesia dengan nama hari dan waktu (HH.MM) ---
        function formatDateID(dateInput) {
            if (!dateInput) return "";
            let d = new Date(dateInput);
            if (isNaN(d)) {
                // Try replacing space with 'T' (e.g., "YYYY-MM-DD HH:MM:SS")
                const iso = String(dateInput).replace(' ', 'T');
                d = new Date(iso);
                if (isNaN(d)) {
                    // Heuristic parse for YYYY-MM-DD or DD-MM-YYYY
                    const parts = String(dateInput).split(/[-\/ ]/);
                    if (parts.length >= 3) {
                        const [a, b, c] = parts;
                        if (a.length === 4) {
                            d = new Date(`${a}-${b}-${c}`);
                        } else {
                            d = new Date(`${c}-${b}-${a}`);
                        }
                    }
                }
            }
            if (isNaN(d)) return String(dateInput);

            // Date part: weekday, day month year (e.g., "Jumat, 2 Januari 2026")
            const datePart = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(d);

            // Time part: HH.MM (24-hour, dot separator)
            const hh = String(d.getHours()).padStart(2, '0');
            const mm = String(d.getMinutes()).padStart(2, '0');
            const timePart = `${hh}:${mm}`;

            return `${datePart} ${timePart}`;
        }

        // --- Infinite scroll ---
        window.addEventListener("scroll", () => {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
            const clientHeight = document.documentElement.clientHeight;
            if (scrollTop + clientHeight >= scrollHeight - 150) loadMore();
        });

        // --- Initial load ---
        loadMore();

    </script>

</body>

</html>