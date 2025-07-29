<?php

class Pagination
{
    private int $totalItems;
    private int $itemsPerPage;
    private int $currentPage;
    private int $totalPages;
    private array $queryParams;
    private string $baseUrl;

    public function __construct(int $totalItems, int $itemsPerPage = 10, int $currentPage = 1, array $queryParams = [])
    {
        $this->totalItems = max(0, $totalItems);
        $this->itemsPerPage = max(1, $itemsPerPage);
        $this->totalPages = $this->calculateTotalPages();
        $this->currentPage = $this->validateCurrentPage($currentPage);
        $this->queryParams = $queryParams;
        $this->baseUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function calculateTotalPages(): int
    {
        return $this->totalItems > 0 ? (int) ceil($this->totalItems / $this->itemsPerPage) : 1;
    }

    private function validateCurrentPage(int $page): int
    {
        return min(max(1, $page), $this->totalPages);
    }

    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getLimit(): int
    {
        return $this->itemsPerPage;
    }

    public function generatePageUrl(int $page): string
    {
        $params = array_merge($this->queryParams, ['p' => $page > 1 ? $page : null]);
        $queryString = http_build_query(array_filter($params));
        
        return $this->baseUrl . ($queryString ? '?' . $queryString : '');
    }

    public function getPaginationData(): array
    {
        return [
            'totalItems' => $this->totalItems,
            'itemsPerPage' => $this->itemsPerPage,
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
            'from' => $this->totalItems > 0 ? $this->getOffset() + 1 : 0,
            'to' => min($this->getOffset() + $this->itemsPerPage, $this->totalItems),
        ];
    }

    public function render(): string
    {
        if ($this->totalPages <= 1) {
            return '';
        }

        $mobilePagination = $this->renderMobilePagination();
        $paginationInfo = $this->renderPaginationInfo();
        $desktopPagination = $this->renderDesktopPagination();

        return <<<HTML
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            {$mobilePagination}
            
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">{$paginationInfo}</p>
                </div>
                
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {$desktopPagination}
                    </nav>
                </div>
            </div>
        </div>
        HTML;
    }

    private function renderMobilePagination(): string
    {
        $html = '';
        $prevPage = $this->currentPage - 1;
        $nextPage = $this->currentPage + 1;

        if ($this->currentPage > 1) {
            $html .= $this->renderPageLink($prevPage, 'Précédent', 'prev-mobile');
        }

        if ($this->currentPage < $this->totalPages) {
            $html .= $this->renderPageLink($nextPage, 'Suivant', 'next-mobile', $html ? 'ml-3' : '');
        }

        return $html ? '<div class="flex-1 flex justify-between sm:hidden">' . $html . '</div>' : '';
    }

    private function renderDesktopPagination(): string
    {
        $html = $this->renderPreviousButton();
        $html .= $this->renderPageNumbers();
        $html .= $this->renderNextButton();
        
        return $html;
    }

    private function renderPreviousButton(): string
    {
        if ($this->currentPage <= 1) return '';

        return $this->renderPageLink(
            $this->currentPage - 1,
            '<span class="sr-only">Précédent</span><i class="ri-arrow-left-s-line"></i>',
            'prev',
            'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50'
        );
    }

    private function renderNextButton(): string
    {
        if ($this->currentPage >= $this->totalPages) return '';

        return $this->renderPageLink(
            $this->currentPage + 1,
            '<span class="sr-only">Suivant</span><i class="ri-arrow-right-s-line"></i>',
            'next',
            'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50'
        );
    }

    private function renderPageNumbers(): string
    {
        $current = $this->currentPage;
        $total = $this->totalPages;
        $start = max(1, $current - 2);
        $end = min($total, $current + 2);
        $html = '';

        // Première page + ellipsis si nécessaire
        if ($start > 1) {
            $html .= $this->renderPageLink(1, '1', 'page-1');
            if ($start > 2) {
                $html .= $this->renderEllipsis();
            }
        }

        // Pages centrales
        for ($i = $start; $i <= $end; $i++) {
            $html .= $this->renderPageLink(
                $i,
                (string) $i,
                "page-$i",
                '',
                $i === $current
            );
        }

        // Dernière page + ellipsis si nécessaire
        if ($end < $total) {
            if ($end < $total - 1) {
                $html .= $this->renderEllipsis();
            }
            $html .= $this->renderPageLink($total, (string) $total, "page-$total");
        }

        return $html;
    }

    private function renderPageLink(
        int $page,
        string $label,
        string $id = '',
        string $additionalClasses = '',
        bool $isActive = false
    ): string {
        $baseClasses = 'relative inline-flex items-center px-4 py-2 border text-sm font-medium';
        $activeClasses = 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600';
        $inactiveClasses = 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50';

        $classes = $isActive 
            ? "$baseClasses $activeClasses $additionalClasses"
            : "$baseClasses $inactiveClasses $additionalClasses";

        return sprintf(
            '<a href="%s" id="%s" class="%s">%s</a>',
            $this->generatePageUrl($page),
            $id,
            trim($classes),
            $label
        );
    }

    private function renderEllipsis(): string
    {
        return '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
    }

    private function renderPaginationInfo(): string
    {
        $data = $this->getPaginationData();
        
        return sprintf(
            'Affichage de <span class="font-medium">%d</span> à <span class="font-medium">%d</span> sur <span class="font-medium">%d</span> résultats',
            $data['from'],
            $data['to'],
            $data['totalItems']
        );
    }
}

class PaginatedQuery
{
    public static function paginate(
        string $baseSql,
        array $params = [],
        int $currentPage = 1,
        int $perPage = 10
    ): array {
        $currentPage = max(1, $currentPage);
        $perPage = max(1, $perPage);

        // Compter le nombre total d'éléments
        $countSql = "SELECT COUNT(*) AS total_count FROM ($baseSql) AS subquery";
        $countResult = fetchResult($countSql, $params, false);

        if (!$countResult || !isset($countResult['total_count'])) {
            return [
                'data' => [],
                'pagination' => new Pagination(0, $perPage, $currentPage)
            ];
        }

        $totalItems = (int)$countResult['total_count'];
        $pagination = new Pagination($totalItems, $perPage, $currentPage);

        // Ajouter le LIMIT à la requête principale
        $paginatedSql = "$baseSql LIMIT ? OFFSET ?";
        $paginatedParams = array_merge($params, [$pagination->getLimit(), $pagination->getOffset()]);

        // Exécuter la requête paginée
        $data = fetchResult($paginatedSql, $paginatedParams) ?: [];

        return [
            'data' => $data,
            'pagination' => $pagination
        ];
    }
}