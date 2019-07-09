<?php
$this->Csv->addRow($th);
foreach ($backers as $b) {
    $this->Csv->addField(h($b['BackedProject']['status']));
    if ($b['BackedProject']['manual_flag']) {
        $method = '手動入金';
    } else if ($b['BackedProject']['bank_flag']) {
        echo '銀行振込';
    } else {
        $method = 'カード決済';
    }
    $this->Csv->addField($method);
    $this->Csv->addField(h($b['BackedProject']['stripe_charge_id']));
    $paid_status = $b['BackedProject']['bank_paid_flag'] ? '済' : '未';
    $this->Csv->addField($paid_status);
    $this->Csv->addField(h($b['User']['nick_name']));
    $this->Csv->addField(h($b['User']['name']));
    $this->Csv->addField(h($b['User']['email']));
    $this->Csv->addField(h($b['User']['receive_address']));
    $this->Csv->addField(h($b['BackedProject']['created']));
    $this->Csv->addField(number_format(h($b['BackedProject']['invest_amount'])) . '円');
    $this->Csv->addField(h($b['BackingLevel']['name']));
    $this->Csv->addField(h($b['BackingLevel']['return_amount']));
    $this->Csv->addField(h($b['BackedProject']['comment']));
    $this->Csv->endRow();
}
$this->Csv->setFilename($filename);
echo $this->Csv->render(true, 'sjis', 'utf-8');
//echo $this->Csv->render();
