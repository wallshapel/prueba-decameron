function Paginator({ meta, onPageChange }) {
  const { current_page, last_page, links } = meta

  const getPageFromUrl = (url) => {
    const match = url?.match(/page=(\d+)/)
    return match ? parseInt(match[1]) : null
  }

  return (
    <div className="flex flex-wrap items-center justify-center gap-2 mt-6">
      <button
        className="px-3 py-1 text-sm border rounded hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed"
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
              className="px-3 py-1 text-sm border rounded hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed"
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
              className="px-3 py-1 text-sm border rounded hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed"
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
            className={`px-3 py-1 text-sm border rounded hover:bg-blue-50 ${
              link.active ? 'bg-blue-100 font-semibold border-blue-400' : ''
            }`}
            onClick={() => onPageChange(pageNumber)}
            disabled={link.active}
          >
            {link.label}
          </button>
        )
      })}

      <button
        className="px-3 py-1 text-sm border rounded hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed"
        onClick={() => onPageChange(last_page)}
        disabled={current_page === last_page}
      >
        Última
      </button>
    </div>
  )
}

export default Paginator
