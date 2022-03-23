<?php
    $employees = [
        [
            'id' => 1,
            'name' => 'John',
            'performance' => 1,
            'rate' => 1
        ],
        [
            'id' => 2,
            'name' => 'Bert',
            'performance' => 5,
            'rate' => 3
        ],
        [
            'id' => 3,
            'name' => 'Greg',
            'performance' => 7,
            'rate' => 5
        ],
        [
            'id' => 4,
            'name' => 'Joe',
            'performance' => 10,
            'rate' => 7
        ],
    ];

    $timings = [];
    $employeeCupCounters = [];

    foreach ($employees as $employee) {
        $timings[$employee['id']] = 3600 / $employee['performance'];
        $employeeCupCounters[$employee['id']] = 0;
    }

    $count = 0;
    $order = $_POST['order'] ? : 0;
    $time = 0;

    while ($count < $order) {
        foreach ($timings as $id => $timing) {
            if ($timing * ($employeeCupCounters[$id] + 1) <= $time) {
                $employeeCupCounters[$id]++;
                $count++;
            }
        }
        $time++;
    }

    $over = $count - $order;
    // exclude over cups for most expensive employee
    while ($over > 0) {
        $maxRate = 0;
        foreach ($employees as $employee) {
            if ($employee['rate'] > $maxRate && $employeeCupCounters[$employee['id']] > 1) {
                $maxRate = $employee['rate'];
                $maxRateEmployee = $employee['id'];
            }
        }
        if ($maxRate) {
            $employeeCupCounters[$maxRateEmployee]--;
            $over--;
        }
    }

?>

<!DOCTYPE HTML>
<html>
<style>
    table.info {
        border-collapse: collapse;
        border: 1pt solid black;
    }
    .info td {
        font-size: 10pt;
        padding: 2pt 3pt 2pt 3pt;
        border: 1pt solid black;
    }
    .info th {
        font-size: 10pt;
        padding: 2pt 3pt 2pt 3pt;
        border: 1pt solid black;
        background: grey;
    }
</style>
<body>
<form action="#" method="post">
    Order: <input type="text" name="order" placeholder="Ender number of cups">
    <input type="submit" name="op">
</form>
<br>
<table class="info">
    <tr class="header">
        <th class="field-value">name</th>
        <th class="field-value">performance, cup/hour</th>
        <th class="field-value">assigned cups, pcs</th>
        <th class="field-value">earned, $</th>
    </tr>
    <?php
    $price = 0;
    foreach ($employees as $employee) {
        $price = $price + $employeeCupCounters[$employee['id']] * $employee['rate']
        ?>
        <tr>
            <td class="field-value"><?= $employee['name']?></td>
            <td class="field-value"><?= $employee['performance']?></td>
            <td class="field-value"><?= $employeeCupCounters[$employee['id']]?></td>
            <td class="field-value"><?= $employeeCupCounters[$employee['id']] * $employee['rate']?></td>
        </tr>
    <?php } ?>
</table>
<br>
<table class="info">
    <tr class="header">
        <th>total cups</th>
    </tr>
    <tr>
        <td><?= $_POST['order']?></td>
    </tr>
    <tr class="header">
        <th>total time</th>
    </tr>
    <tr>
        <td><?= $time ? date('H:i:s', $time - 1) : 0?></td>
    </tr>
    <tr class="header">
        <th>total money</th>
    </tr>
    <tr>
        <td><?= $price?></td>
    </tr>
</table>
</body>
</html>


