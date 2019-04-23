<?= $this->getPartial('header') ?>

<div class="container">
    <div class="row">
        <div class="col-sm col-xs-6 ">
            <div class="card text-center">
                <div class="card-header">
                    Select a currency
                </div>
                <div class="card-body">
                    <select id="currencySelect" class="form-control"
                            onchange="updateCurrency(document.getElementById('currencySelect').value)">
                        <?php foreach ($this->params['currencyArrayKeys'] as $key): ?>
                            <option value="<?= $key ?>"><?= $key ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="card-footer text-muted table-striped">

                </div>
            </div>
            <table id="gable" class="table table-striped">
                <thead>
                <tr>
                    <th>Currency</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->getPartial('footer') ?>