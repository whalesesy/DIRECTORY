import { Search } from 'lucide-react';

export default function SearchBar({ value, onChange, placeholder = 'Search by name, role, or extension…', compact = false }) {
  return (
    <div className="relative w-full">
      <Search className={`absolute left-3.5 top-1/2 -translate-y-1/2 text-kisii-blue ${compact ? 'w-3.5 h-3.5' : 'w-4.5 h-4.5 w-4 h-4'}`} />
      <input
        type="search"
        value={value}
        onChange={e => onChange(e.target.value)}
        placeholder={placeholder}
        className={`
          w-full pl-10 pr-4 bg-kisii-white border border-kisii-border
          text-kisii-text placeholder:text-kisii-text-muted
          focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue
          shadow-sm transition-all duration-200
          ${compact ? 'py-2 text-sm rounded-full' : 'py-3.5 rounded-2xl text-base'}
        `}
      />
    </div>
  );
}
