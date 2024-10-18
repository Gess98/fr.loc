<?php

namespace PHPFramework;

class Pagination
{
    // Общеее количество страниц
    protected int $countPages;

    // Текущая страница
    protected int $currentPage;

    // Ссылка для текущей страницы
    protected string $uri;

    public function __construct(
        // всего записей
        protected int $totalRecords,
        // количество записей на странице (переопределить можно в конфиге)
        protected int $perPage = PAGINATION_SETTINGS['perPage'],
        // количество отображаемых страниц слева и справа от выбранной страницы (переопределить можно в конфиге)
        protected int $midSize = PAGINATION_SETTINGS['midSize'],
        // Если страниц не больше данного параметра, то в пагинации отобразятся все ссылки на эти страницы (переопределить можно в конфиге)
        protected int $maxPages = PAGINATION_SETTINGS['maxPages'],
        // путь до шаблона с пагинацией (переопределить можно в конфиге)
        protected string $tpl = PAGINATION_SETTINGS['tpl'],
    )
    {
        // Общее количество страниц
        $this->countPages = $this->getCountPages();
        // Текущая страница
        $this->currentPage = $this->getCurrentPage();
        // Ссылка без page
        $this->uri = $this->getParams();
        $this->midSize = $this->getMidSize();
    }

    // Подсчет общего количества страниц
    protected function getCountPages(): int
    {
        return (int)ceil($this->totalRecords/$this->perPage) ?: 1;
    }

    // Получение текущей страницы
    protected function getCurrentPage(): int
    {
        $page = (int)request()->get('page', 1);
        if ($page < 1 || $page > $this->countPages) {
            abort();
        }

        return $page;
    }

    // Получение get парметров и удаление праметра page
    protected function getParams()
    {
        $url = request()->uri;
        // разделяет url на составляющие и возвращает массив
        $url = parse_url($url);
        $uri = $url['path'];
        if (!empty($url['query']) && $url['query'] != '&') {
            // разделяет строку по компонентам
            parse_str($url['query'], $params);
            // проверка на наличие ключа page в массиве params
            if (isset($params['page'])) {
                unset($params['page']);
            }

            if(!empty($params)) {
                // Сбор параметров в строку запроса
                $uri .= '?' . http_build_query($params);
            }
        }
        return $uri;
    }

    protected function getMidSize(): int 
    {
        // Если всего страниц меньше, чем максимально допустипое количество страниц, то вернется общее количество страниц
        // а иначе вернется боковой интервал
        return ($this->countPages <= $this->maxPages) ? $this->countPages : $this->midSize;
    }

    // С какой записи отображается страница (какой отступ в записях)
    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getHtml()
    {
        // Шаг назад
        $back = '';
        // Шаг вперед
        $forward = '';
        // Начальная страница
        $first_page = '';
        // Последняя страница
        $last_page = '';
        // Страницы слева
        $pages_left = [];
        // Страницы справа
        $pages_right = [];
        // Текущая страница
        $current_page = $this->currentPage;

        if ($this->currentPage > 1) {
            // Количество страниц перед текущей страницей
            $back = $this->getLink($this->currentPage - 1);
        }

        if ($this->currentPage < $this->countPages) {
            // Количество страниц после текущей страницей
            $forward = $this->getLink($this->currentPage + 1);
        }

        if ($this->currentPage > $this->midSize + 1) {
            // Ссылка на первую страницу
            $first_page = $this->getLink(1);
        }

        if ($this->currentPage < $this->countPages - $this->midSize) {
            // Ссылка на последнюю страницу
            $last_page = $this->getLink($this->countPages);
        }

        for ($i = $this->midSize; $i > 0; $i--) {
            if ($this->currentPage - $i > 0) {
                // страницы слева от текущей
                $pages_left[] = [
                    'link' => $this->getLink($this->currentPage - $i),
                    'number' => $this->currentPage - $i,
                ];
            }
        }

        for ($i = 1; $i <= $this->midSize; $i++) {
            if ($this->currentPage + $i <= $this->countPages) {
                // страницы справа от текущей
                $pages_right[] = [
                    'link' => $this->getLink($this->currentPage + $i),
                    'number' => $this->currentPage + $i,
                ];
            }
        }


        return view()->renderPartial($this->tpl, compact('back', 'forward', 'first_page', 'last_page', 'pages_left', 
        'pages_right', 'current_page'));
    }

    // Формирование строки запроса
    protected function getLink($page): string
    {
        if ($page == 1) {
            return rtrim($this->uri, '?&');
        }

        if (str_contains($this->uri, '&') || str_contains($this->uri, '?')) {
            return "{$this->uri}&page={$page}";
        } else {
            return "{$this->uri}?page={$page}";
        }
    }

    public function __toString(): string
    {
        return $this->getHtml();
    }
}