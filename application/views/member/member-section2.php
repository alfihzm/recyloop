<section class="section bg-pattern-1">
    <img src="<?= base_url('assets/') ?>images/patterns/7.png" alt="img" class="patterns-7">
    <img src="<?= base_url('assets/') ?>images/patterns/2.png" alt="img" class="patterns-1 op-1">
    <img src="<?= base_url('assets/') ?>images/patterns/9.png" alt="img"
        class="patterns-3 filter-invert sub-pattern-2 op-2">
    <div class="container">
        <div class="heading-section">
            <div class="heading-subtitle"><span class="tx-primary tx-16 fw-semibold">Tukar</span></div>
            <div class="heading-title">Limbah <span class="tx-primary"> Daur Ulang</span> </div>
            <div class="heading-description">Jenis limbah yang dapat kami terima.</div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($limbah as $l) : ?>
            <div class="col-lg-4">
                <div class="card pricing-card border mb-lg-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h4 class="mb-0"><?= $l['jenis_sampah']; ?></h4>
                            </div>
                        </div>
                        <p class="mb-1 tx-muted">Harga</p>
                        <h2 class="mb-3">Rp<?= $l['nilai_tukar']; ?><span
                                class="tx-14 op-7 tx-muted">/<?= $l['jenis_sampah']; ?></span>
                        </h2>
                        <p class="mb-4">Menerima berbagi jenis <?= strtolower($l['jenis_sampah']); ?> yang ada miliki.
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>