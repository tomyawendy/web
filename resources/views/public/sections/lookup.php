<section class="lookup-strip" id="services">
    <div class="container">
        <p><?= e(setting_value($settings, 'lookup_label', "I'm looking for")) ?></p>
        <div class="lookup-pills">
            <?php foreach (array_slice($services, 0, 4) as $service): ?>
                <a href="<?= e(app_url('services/' . $service['slug'])) ?>"><?= e($service['title']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
