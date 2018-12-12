<?php

/**
 * Detect Active Path
 *
 * Compare given path with the current path and return output if they match.
 * Very useful for navigation, marking if the link is active.
 *
 * @param string $path
 * @param string $output
 *
 * @param null   $contains
 *
 * @return string
 */
function activeIfPath(string $path, string $output = 'active', $contains = null): string
{
    if (Request::is($path) && !Request::is($contains)) {
        return $output;
    }

    return '';
}

/**
 * Session Notification Helper
 *
 * @param string $message
 * @param string $type
 * @param int    $timeout
 *
 * @return void
 */
function notification(string $message, string $type = 'success', int $timeout = 3000)
{
    session()->flash('notification', [
        'type' => $type,
        'text' => $message,
        'timeout' => $timeout,
    ]);
}

/**
 * JSON Notification Helper
 *
 * @param string $message
 * @param string $type
 * @param int    $timeout
 *
 * @param int    $status_code
 *
 * @return \Illuminate\Http\JsonResponse
 */
function jsonNotification(string $message, string $type = 'success', int $timeout = 3000, $status_code = 200)
{
    return response()->json([
        'notification' => [
            'type' => $type,
            'text' => $message,
            'timeout' => $timeout,
        ],
    ], $status_code);
}


/**
 * Paginate a collection.
 *
 * @param array | Illuminate\Support\Collection $items
 * @param int $perPage
 * @param int $page
 * @param array $options
 *
 * @return Illuminate\Pagination\LengthAwarePaginator
 */
function paginateCollection($items, $perPage = 15, $page = null, $options = [])
{
    $page = $page ?: (Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

    $items = $items instanceof Illuminate\Support\Collection
        ? $items
        : collect($items);

    return new Illuminate\Pagination\LengthAwarePaginator(
        $items->forPage($page, $perPage),
        $items->count(),
        $perPage,
        $page,
        $options
    );
}