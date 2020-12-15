// ganti tahun aktif
async function ganti_ta() {
    let data = {
        'tahun': document.getElementById('tahun').value
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    };
    try {
        const response = await fetch(site_url + 'ref_tahun_akademik/ganti_ta', options);
        const json = await response.json();
        // console.log(json);
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
        } else {
            // tampil notif
            notif(json.message, json.type);
        }
    } catch (error) {
        console.log(error);
        // tampil notif
        notif(error, 'error');
    }
}