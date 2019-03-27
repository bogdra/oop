

<?=$this->getPartial('header')?>


<div class="card text-center">
    <div class="card-header">
        Select a currency
    </div>
    <div class="card-body">
        <select id="currencySelect" class="form-control" onchange="updateCurrency(document.getElementById('currencySelect').value)">
            <?php foreach($this->params['currencyArrayKeys'] as $key): ?>
                <option value="<?=$key?>"><?=$key?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="card-footer text-muted">

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
        <tr>
            <td>John</td>
            <td>Doe</td>
        </tr>
        <tr>
            <td>Mary</td>
            <td>Moe</td>
        </tr>
        <tr>
            <td>July</td>
            <td>Dooley</td>
        </tr>
        </tbody>
    </table>

<?=$this->getPartial('footer')?>