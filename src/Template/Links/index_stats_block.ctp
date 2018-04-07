<div  id="id="stats-container" class="third_section stats_section" style="padding-top:0px;">
    <div class="my_container stats_container" style="max-width: 100%;">
        <div class="row">
            <div class="col-md-12 sec_60">
                <div class="">
                    <div class="row">
                        <div class="col- col-md-6 col-lg-3  box_2">
                            <div>
                                <h3><?= $this->Number->format($totals->impression_count) ?> 🔥</h3>
                                <p><?= __('Impressions') ?></p>
                            </div>
                        </div>
                        <div class="col- col-md-6 col-lg-3  box_2">
                            <div>
                                <h3><?= $this->Number->format($totals->use_count) ?> 🦁</h3>
                                <p><?= __('Uses') ?></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col- col-md-6 col-lg-3  box_2">
                            <div>
                                <h3><?= $this->Number->format($totals->completion_count) ?> 🍾<h3>
                                <p><?= __('Completions') ?></p>
                            </div>
                        </div>
                        <div class="col- col-md-6 col-lg-3  box_2">
                            <div>
                                <h3 style="font-size: 18px">
                                <ol class="list-unstyled">
                                    <?php foreach($statistics as $statistic) : ?>
                                        <li><?= $statistic->country ?></li>
                                    <?php endforeach; ?>
                                    </ol>
                                 🌐</h3>
                                <p><?= __('Top Countries') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
