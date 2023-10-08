<div class="flex items-center gutter-md items-center">
    <div class="chip pa-xs method">{{ $result->getRequestMethod() }}</div>
    <div class="chip pa-xs duration">{{ $result->getTotalTimeElapsedInMilliseconds(0) }} ms</div>
    <?php $path = $result->getRequestPath() ?>
    <div class="font-bold text-monospace">{{ strlen($path) > 80 ? '..' . substr($path, -80) : $path }}</div>
</div>
