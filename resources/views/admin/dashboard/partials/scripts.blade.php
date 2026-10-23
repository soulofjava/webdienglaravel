<script>
    // 1. Live Input Count & Live SERP / WhatsApp Sync
    const inputSiteName = document.getElementById('inputSiteName');
    const inputSeoTitle = document.getElementById('inputSeoTitle');
    const inputSeoDesc = document.getElementById('inputSeoDesc');
    const inputOgUrl = document.getElementById('inputOgUrl');

    const seoTitleCount = document.getElementById('seoTitleCount');
    const seoDescCount = document.getElementById('seoDescCount');

    const previewGoogleTitle = document.getElementById('previewGoogleTitle');
    const previewGoogleDesc = document.getElementById('previewGoogleDesc');
    const previewWaTitle = document.getElementById('previewWaTitle');
    const previewWaDesc = document.getElementById('previewWaDesc');
    const previewWaImage = document.getElementById('previewWaImage');
    const ogPreview = document.getElementById('ogPreview');

    const inputTagline = document.querySelector('input[name="site_tagline"]');

    function syncLivePreviews() {
        const activeSiteName = inputSiteName.value.trim() || 'TIKETDIENG.COM';
        const activeTagline = inputTagline?.value.trim() || 'Biro Wisata Dataran Tinggi Dieng';
        inputSeoTitle.placeholder = `Otomatis mengikuti: ${activeSiteName} — ${activeTagline}`;

        const title = inputSeoTitle.value.trim() || `${activeSiteName} — ${activeTagline}`;
        const desc = inputSeoDesc.value.trim() || 'Biro perjalanan wisata resmi Dataran Tinggi Dieng dengan layanan VIP...';
        const ogUrl = inputOgUrl.value.trim() || 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop';

        seoTitleCount.innerText = `${inputSeoTitle.value.length}/60 karakter ideal`;
        seoDescCount.innerText = `${inputSeoDesc.value.length}/160 karakter ideal`;

        previewGoogleTitle.innerText = title;
        previewGoogleDesc.innerText = desc;
        previewWaTitle.innerText = title;
        previewWaDesc.innerText = desc;
        previewWaImage.src = ogUrl;
        ogPreview.src = ogUrl;
    }

    inputSiteName?.addEventListener('input', syncLivePreviews);
    inputTagline?.addEventListener('input', syncLivePreviews);
    inputSeoTitle?.addEventListener('input', syncLivePreviews);
    inputSeoDesc?.addEventListener('input', syncLivePreviews);
    inputOgUrl?.addEventListener('input', syncLivePreviews);

    async function compressImageIfNeeded(file, maxDimension = 1920, quality = 0.85) {
        if (!file || !file.type.startsWith('image/') || file.type === 'image/svg+xml' || file.type === 'image/x-icon') {
            return file;
        }
        if (file.size < 1.5 * 1024 * 1024) {
            return file;
        }
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let width = img.width;
                    let height = img.height;
                    if (width > maxDimension || height > maxDimension) {
                        if (width > height) {
                            height = Math.round((height * maxDimension) / width);
                            width = maxDimension;
                        } else {
                            width = Math.round((width * maxDimension) / height);
                            height = maxDimension;
                        }
                    }
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    const outputType = 'image/jpeg';
                    canvas.toBlob((blob) => {
                        if (blob && blob.size < file.size) {
                            const newName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                            const newFile = new File([blob], newName, { type: outputType, lastModified: Date.now() });
                            resolve(newFile);
                        } else {
                            resolve(file);
                        }
                    }, outputType, quality);
                };
                img.onerror = () => resolve(file);
                img.src = e.target.result;
            };
            reader.onerror = () => resolve(file);
            reader.readAsDataURL(file);
        });
    }

    // 2. Favicon Upload Ajax Handler
    const fileFavicon = document.getElementById('fileFavicon');
    const faviconPreview = document.getElementById('faviconPreview');
    const inputFaviconUrl = document.getElementById('inputFaviconUrl');
    const faviconText = document.getElementById('faviconText');
    const faviconBtnText = document.getElementById('faviconBtnText');

    fileFavicon?.addEventListener('change', async (e) => {
        if (!e.target.files || !e.target.files[0]) return;
        let file = e.target.files[0];

        faviconBtnText.innerText = 'Mengunggah...';

        try {
            file = await compressImageIfNeeded(file, 512, 0.9);
            const formData = new FormData();
            formData.append('favicon', file);
            formData.append('site_key', '{{ $selectedSite }}');
            formData.append('_token', '{{ csrf_token() }}');

            const res = await fetch('{{ route('admin.upload.favicon') }}', {
                method: 'POST',
                body: formData,
            });

            if (!res.ok) {
                const errText = await res.text();
                let errMsg = 'Gagal mengunggah favicon (Status: ' + res.status + ')';
                try {
                    const parsed = JSON.parse(errText);
                    if (parsed.message) errMsg = parsed.message;
                    if (parsed.errors && parsed.errors.favicon) errMsg = parsed.errors.favicon[0];
                } catch(e) {}
                alert(errMsg);
                return;
            }

            const data = await res.json();
            if (data.success) {
                faviconPreview.src = data.url;
                inputFaviconUrl.value = data.url;
                faviconText.innerText = data.url;
                alert('Favicon berhasil diunggah dan diperbarui!');
            } else {
                alert(data.message || 'Gagal mengunggah favicon.');
            }
        } catch (err) {
            alert('Terjadi kesalahan saat mengunggah berkas: ' + err.message);
        } finally {
            faviconBtnText.innerText = 'Unggah Berkas Baru';
        }
    });

    // 3. OG Image Banner Upload Ajax Handler
    const fileOg = document.getElementById('fileOg');
    const ogBtnText = document.getElementById('ogBtnText');
    const ogText = document.getElementById('ogText');

    fileOg?.addEventListener('change', async (e) => {
        if (!e.target.files || !e.target.files[0]) return;
        let file = e.target.files[0];

        ogBtnText.innerText = 'Mengoptimasi & Mengunggah...';

        try {
            file = await compressImageIfNeeded(file, 1920, 0.85);
            const formData = new FormData();
            formData.append('og_image', file);
            formData.append('site_key', '{{ $selectedSite }}');
            formData.append('_token', '{{ csrf_token() }}');

            const res = await fetch('{{ route('admin.upload.og') }}', {
                method: 'POST',
                body: formData,
            });

            if (!res.ok) {
                const errText = await res.text();
                let errMsg = 'Gagal mengunggah banner (Status: ' + res.status + ')';
                try {
                    const parsed = JSON.parse(errText);
                    if (parsed.message) errMsg = parsed.message;
                    if (parsed.errors && parsed.errors.og_image) errMsg = parsed.errors.og_image[0];
                } catch(e) {}
                alert(errMsg);
                return;
            }

            const data = await res.json();
            if (data.success) {
                inputOgUrl.value = data.url;
                ogPreview.src = data.url;
                previewWaImage.src = data.url;
                ogText.innerText = data.url;
                alert('Banner media sosial berhasil diunggah!');
            } else {
                alert(data.message || 'Gagal mengunggah banner.');
            }
        } catch (err) {
            alert('Terjadi kesalahan saat mengunggah berkas: ' + err.message);
        } finally {
            ogBtnText.innerText = 'Unggah Banner Baru';
        }
    });
</script>
