 <?php
    function create_time_range(string $start_time, string $end_time, string $interval): array
    {
        $times = [];
        $start = strtotime($start_time);
        $end = strtotime($end_time);
        $current = $start;
        while ($current <= $end) {
            $times[] = date('H:i:s', $current);
            $current = strtotime($interval, $current);
        }
        return $times;
    }
    ?>