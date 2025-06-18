<style>
        /* Pastikan konten utama tidak overflow */
    .content {
        overflow-x: hidden; /* Menghindari scroll horizontal */
        margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
        transition: margin-left 0.3s ease-in-out; /* Animasi saat sidebar dibuka/tutup */
    }

    /* Jika sidebar ditutup */
    .content.full {
        margin-left: 0; /* Konten mengambil lebar penuh */
    }

    /* Pastikan elemen dalam kolom tidak overflow */
    #rack-data {
        display: flex;
        flex-wrap: wrap; /* Membungkus elemen jika terlalu panjang */
        overflow-x: hidden; /* Menghindari scroll horizontal */
    }

    .row.g-3 {
        margin: 0; /* Menghindari margin yang menyebabkan overflow */
    }

    .row.g-3 > div {
        flex: 0 0 auto; /* Pastikan elemen tetap dalam baris */
    }

    .indicator-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px; /* Jarak antar indikator */
        flex-wrap: nowrap; /* Mencegah indikator berpindah baris */
    }

    .led {
        width: 40px;
        height: 40px;
        border-radius: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4), 0 2px 1px rgba(0, 0, 0, .08);
        cursor: pointer;
        flex-shrink:  0;
    }

    .led::after {
        display: block;
        content: "";
        width: 30px;
        height: 24px;
        border-radius: 100%;
        margin: 4px auto;
        background: rgb(255, 255, 255);
        background: linear-gradient(0deg, rgba(255, 255, 255, .2) 0%, rgba(255, 255, 255, .8) 100%);
    }

    .led-green {
        background: rgb(0, 255, 0);
        background: linear-gradient(0deg, rgba(255, 243, 255, 1) 0%, rgba(0, 255, 0, .8) 100%);
    }

    .led-green.on {
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 1) 50%, rgba(0, 255, 0, 1) 100%);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4), 0 2px 1px rgba(0, 0, 0, .08), 0 0 20px rgba(0, 255, 0, .5), 0 0 5px 5px rgba(255, 255, 255, 1);
    }

    .led-red {
        background: rgb(175, 20, 0);
        background: linear-gradient(0deg, rgba(255, 255, 255, 1) 0%, rgba(175, 20, 0, 1) 100%);
    }

    .led-red.on {
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 1) 50%, rgba(255, 0, 0, 1) 100%);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4), 0 2px 1px rgba(0, 0, 0, .08), 0 0 20px rgba(255, 0, 0, .5), 0 0 5px 5px rgba(255, 255, 255, 1);
    }

    .led-orange {
        background: rgb(255, 165, 0);
        background: linear-gradient(0deg, rgba(255, 255, 255, 1) 0%, rgba(255, 165, 0, 1) 100%);
    }

    .led-orange.on {
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 1) 50%, rgba(255, 165, 0, 1) 100%);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4), 0 2px 1px rgba(0, 0, 0, .08), 0 0 20px rgba(255, 165, 0, .5), 0 0 5px 5px rgba(255, 255, 255, 1);
    }
</style>

<script>
    $(document).ready(function() {
        function loadData() {
            $.ajax({
                url: 'api/weapons',
                type: 'GET',
                success: function(response) {
                    updateUI(response.data);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        function updateUI(data) {
            $('#rack-data').empty();
            if (data.length > 0) {
                data.forEach(function (rackData) {
                    // Elemen utama untuk setiap rack
                    var rackElement = $('<div>', {
                        class: 'col-lg-4 col-md-6 col-sm-12',
                        style: 'max-width: 300px;'
                    });

                    // Kartu untuk setiap load cell
                    var card = $('<div>', {
                        class: 'card shadow-sm m-2'
                    });

                    // Body kartu
                    var cardBody = $('<div>', {
                        class: 'card-body text-center'
                    });

                    // Judul kartu
                    var cardTitle = $('<h6>', {
                        class: 'card-title mb-3 text-secondary',
                        style: 'text-align: center;',
                        text: 'Load Cell ' + rackData.loadCellID
                    });

                    // Indikator status
                    var indicator = $('<div>', {
                        class: 'indicator-container' // Gunakan kelas baru
                    });

                    // Indikator warna
                    var lightRed = $('<div>', {
                        class: 'led led-red ' + (rackData.status == 0 ? 'on' : '')
                    });

                    var lightYellow = $('<div>', {
                        class: 'led led-orange ' + (rackData.status == 1 ? 'on' : '')
                    });

                    var lightGreen = $('<div>', {
                        class: 'led led-green ' + (rackData.status == 2 ? 'on' : '')
                    });

                    // Tambahkan indikator ke dalam container
                    indicator.append(lightRed, lightYellow, lightGreen);

                    // Susun elemen kartu
                    cardBody.append(cardTitle, indicator);
                    card.append(cardBody);
                    rackElement.append(card);

                    // Tambahkan elemen rack ke dalam container utama
                    $('#rack-data').append(rackElement);
                });
            } else {
                // Jika data tidak tersedia
                $('#rack-data').html('<p class="text-center text-muted">Data tidak tersedia.</p>');
            }
        }

        loadData();
        setInterval(loadData, 2000);
    });
</script>
