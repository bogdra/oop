

<?=$this->getPartial('header')?>


Convert Euro To :
<form method="POST" action="#">
    <select id="currencySelect" class="" onchange="updateCurrency()">
        <?php foreach($this->params['currencyArray'] as $key => $value): ?>
        <option value="<?=$value?>"><?=$key?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Convert" />
</form>


<?=$this->getPartial('footer')?>