function Paginator({ meta, onPageChange }) {
    const { current_page, last_page, links } = meta

    const getPageFromUrl = (url) => {
        const match = url?.match(/page=(\d+)/)
        return match ? parseInt(match[1]) : null
    }

    const firstPage = getPageFromUrl(links.find(l => l.label === '1')?.url)
    const lastPage = getPageFromUrl(links.find(l => l.label === String(last_page))?.url)

    return (
        <div>

            <button
                onClick={() => onPageChange(1)}
                disabled={current_page === 1}
            >
                Primera
            </button>

            {links.map((link, index) => {
                const pageNumber = getPageFromUrl(link.url)

                if (link.label === '&laquo; Previous') {
                    return (
                        <button
                            key={index}
                            onClick={() => onPageChange(current_page - 1)}
                            disabled={!link.url}
                        >
                            Anterior
                        </button>
                    )
                }

                if (link.label === 'Next &raquo;') {
                    return (
                        <button
                            key={index}
                            onClick={() => onPageChange(current_page + 1)}
                            disabled={!link.url}
                        >
                            Siguiente
                        </button>
                    )
                }

                return (
                    <button
                        key={index}
                        onClick={() => onPageChange(pageNumber)}
                        disabled={link.active}
                    >
                        {link.label}
                    </button>
                )
            })}

            <button
                onClick={() => onPageChange(last_page)}
                disabled={current_page === last_page}
            >
                Última
            </button>
        </div>
    )
}

export default Paginator
