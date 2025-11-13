@php
function splitColumns($headers, $rows, $maxColumns = 12) {

    $chunks = array_chunk($headers, $maxColumns);
    $parts = [];

    foreach ($chunks as $index => $headerSet) {

        $partRows = [];

        foreach ($rows as $row) {
            $partRows[] = array_slice($row, $index * $maxColumns, $maxColumns);
        }

        $parts[] = [
            'headers' => $headerSet,
            'rows'    => $partRows,
            'offset'  => $index * $maxColumns
        ];
    }

    return $parts;
}
@endphp
