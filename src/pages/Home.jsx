import { useState, useMemo } from 'react';
import { Phone, ChevronRight, MapPin, Globe } from 'lucide-react';
import { Link } from 'react-router-dom';
import { DEPARTMENTS, COUNTY_LINES } from '../data/departments';
import SearchBar from '../components/SearchBar';
import DeptIcon from '../components/DeptIcon';
import Highlight from '../components/Highlight';

// Flatten all searchable contacts
function buildSearchIndex() {
  const entries = [];
  for (const dept of DEPARTMENTS) {
    entries.push({
      type: 'senior',
      deptId: dept.id,
      deptName: dept.name,
      name: dept.senior.name,
      role: dept.senior.role,
      ext: dept.senior.ext,
    });
    for (const staff of dept.staff) {
      entries.push({
        type: 'staff',
        deptId: dept.id,
        deptName: dept.name,
        name: staff.name,
        role: staff.role,
        ext: staff.ext,
      });
    }
  }
  return entries;
}

const SEARCH_INDEX = buildSearchIndex();

function ContactResult({ contact, query }) {
  return (
    <Link
      to={`/department/${contact.deptId}`}
      className="flex items-start gap-3 p-4 bg-kisii-white rounded-xl border border-kisii-border
        hover:border-kisii-blue/30 hover:shadow-md transition-all group animate-fade-in"
    >
      <div className="w-10 h-10 rounded-full bg-kisii-blue/10 text-kisii-blue
        group-hover:bg-kisii-green/10 group-hover:text-kisii-green
        flex items-center justify-center text-sm font-bold shrink-0 transition-all">
        {contact.name.split(' ').map(n => n[0]).join('').slice(0, 2)}
      </div>
      <div className="flex-1 min-w-0">
        {/* Role — prominent, first */}
        <p className="text-sm sm:text-base font-extrabold text-kisii-blue leading-tight group-hover:text-kisii-green transition-colors">
          <Highlight text={contact.role} query={query} />
        </p>
        {/* Name — secondary */}
        <p className="font-medium text-kisii-text text-xs sm:text-sm mt-0.5">
          <Highlight text={contact.name} query={query} />
        </p>
        <p className="text-xs text-kisii-text-muted mt-0.5">{contact.deptName}</p>
        {contact.ext && (
          <a
            href={`tel:${contact.ext}`}
            onClick={e => e.stopPropagation()}
            className="inline-flex items-center gap-1 mt-1.5 text-xs font-semibold text-kisii-green hover:text-kisii-blue transition-colors"
          >
            <Phone className="w-3 h-3" />
            <Highlight text={`Ext. ${contact.ext}`} query={query} />
          </a>
        )}
      </div>
      <ChevronRight className="w-4 h-4 text-kisii-border group-hover:text-kisii-blue transition-colors shrink-0 mt-1" />
    </Link>
  );
}

function DeptCard({ dept }) {
  return (
    <Link
      to={`/department/${dept.id}`}
      className="group bg-kisii-white rounded-2xl border border-kisii-border
        border-t-4 shadow-sm hover:shadow-xl hover:border-kisii-blue/40
        transition-all duration-300 hover:-translate-y-1 block"
      style={{ borderTopColor: dept.accent.replace('border-t-[', '').replace(']', '') }}
    >
      <div className="p-4 sm:p-5">
        <div className="inline-flex p-2.5 rounded-xl bg-kisii-blue text-kisii-gold mb-3">
          <DeptIcon name={dept.icon} />
        </div>
        <h3 className="font-bold text-kisii-text group-hover:text-kisii-blue transition-colors text-sm sm:text-base leading-tight">
          {dept.name}
        </h3>
        <p className="text-xs sm:text-sm text-kisii-text-muted mt-1.5 font-medium">
          {dept.staff.length + 1} contacts
        </p>
        <div className="mt-3 flex items-center gap-1 text-xs sm:text-sm text-kisii-blue font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
          View directory <ChevronRight className="w-3 h-3" />
        </div>
      </div>
    </Link>
  );
}

export default function Home() {
  const [search, setSearch] = useState('');

  const results = useMemo(() => {
    if (!search.trim()) return [];
    const q = search.toLowerCase();
    return SEARCH_INDEX.filter(
      c =>
        c.name.toLowerCase().includes(q) ||
        c.role.toLowerCase().includes(q) ||
        (c.ext && c.ext.includes(q)) ||
        c.deptName.toLowerCase().includes(q)
    ).slice(0, 20);
  }, [search]);

  return (
    <div className="min-h-screen bg-kisii-surface">
      {/* ── Hero ── */}
      <header className="relative overflow-hidden text-white">
        {/* Flag tricolor */}
        <div className="absolute inset-0 flex flex-col pointer-events-none">
          <div className="flex-[2] bg-kisii-blue" />
          <div className="flex-[1] bg-kisii-white" />
          <div className="flex-[2] bg-kisii-green" />
        </div>

        {/* Subtle overlay pattern */}
        <div className="absolute inset-0 opacity-5"
          style={{
            backgroundImage: 'repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%)',
            backgroundSize: '20px 20px',
          }}
        />

        <div className="relative z-10 w-full px-4 sm:px-8 lg:px-16 py-14 text-center">
          {/* Kenya badge */}
          <div className="inline-flex items-center gap-2 mb-4">
            <div className="w-16 h-1 bg-kisii-gold rounded-full" />
            <p className="text-kisii-gold text-xs sm:text-sm font-bold tracking-widest uppercase select-none">
              Republic of Kenya
            </p>
            <div className="w-16 h-1 bg-kisii-gold rounded-full" />
          </div>

          {/* County seal / logo */}
          <div className="inline-flex items-center justify-center mb-5">
            <img 
              src="/kisii-logo.png" 
              alt="Kisii County Government Logo"
              className="h-20 w-20 sm:h-24 sm:w-24 object-contain drop-shadow-lg animate-fade-in"
            />
          </div>

          <h1 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white drop-shadow-lg tracking-tight">
            Kisii County
          </h1>
          <p className="text-xl sm:text-2xl md:text-3xl text-kisii-gold font-semibold mt-2 mb-2">Government Directory</p>
          <p className="text-white/70 text-sm sm:text-base mb-8 max-w-2xl mx-auto">
            Find any office, officer, or extension in the county government
          </p>

          {/* Search */}
          <div className="max-w-3xl mx-auto">
            <SearchBar value={search} onChange={setSearch} />
          </div>

          {/* County hotlines */}
          <div className="flex flex-wrap justify-center gap-3 mt-6">
            {COUNTY_LINES.map(line => (
              <a
                key={line.number}
                href={`tel:${line.number}`}
                className="inline-flex items-center gap-2 border border-kisii-gold/60
                  bg-kisii-blue-dark/40 hover:bg-kisii-blue-dark/70 backdrop-blur
                  px-4 py-2 rounded-full text-sm sm:text-base transition-all duration-200 font-medium"
              >
                <Phone className="w-3.5 h-3.5 sm:w-4 sm:h-4 text-kisii-gold" />
                {line.label}: <span className="text-kisii-gold-light">{line.number}</span>
              </a>
            ))}
          </div>
        </div>
      </header>

      {/* ── Search Results ── */}
      {search.trim() && (
        <section className="w-full px-4 sm:px-8 lg:px-16 py-6 animate-slide-up">
          <h2 className="text-lg sm:text-xl font-semibold text-kisii-text mb-4">
            {results.length > 0
              ? <>{results.length} result{results.length !== 1 ? 's' : ''} for "<span className="text-kisii-blue">{search}</span>"</>
              : <>No results for "<span className="text-kisii-blue">{search}</span>"</>
            }
          </h2>
          {results.length > 0 ? (
            <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
              {results.map((contact, i) => (
                <ContactResult key={i} contact={contact} query={search} />
              ))}
            </div>
          ) : (
            <div className="text-center py-16 text-kisii-text-muted">
              <Globe className="w-12 h-12 mx-auto mb-3 opacity-30" />
              <p className="font-medium text-base">No contacts match your search.</p>
              <p className="text-sm mt-1">Try a different name, role, or extension number.</p>
            </div>
          )}
        </section>
      )}

      {/* ── Departments Grid ── */}
      {!search.trim() && (
        <main className="w-full px-4 sm:px-8 lg:px-16 py-8">
          {/* Stats bar */}
          <div className="grid grid-cols-3 gap-4 sm:gap-6 mb-8">
            {[
              { label: 'Departments', value: DEPARTMENTS.length, color: 'text-kisii-blue' },
              { label: 'Total Contacts', value: SEARCH_INDEX.length, color: 'text-kisii-green' },
              { label: 'County Lines', value: COUNTY_LINES.length, color: 'text-kisii-gold' },
            ].map(stat => (
              <div key={stat.label} className="bg-kisii-white rounded-2xl border border-kisii-border p-4 sm:p-6 text-center shadow-sm">
                <p className={`text-3xl sm:text-4xl md:text-5xl font-extrabold ${stat.color}`}>{stat.value}</p>
                <p className="text-xs sm:text-sm md:text-base text-kisii-text-muted mt-1 font-semibold">{stat.label}</p>
              </div>
            ))}
          </div>

          {/* Section header */}
          <div className="flex items-center gap-3 mb-5">
            <div className="w-1.5 h-7 rounded-full bg-kisii-gold" />
            <h2 className="text-2xl sm:text-3xl font-bold text-kisii-text">Departments</h2>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            {DEPARTMENTS.map(dept => (
              <DeptCard key={dept.id} dept={dept} />
            ))}
          </div>

          {/* Footer note */}
          <div className="mt-10 p-4 sm:p-6 bg-kisii-white rounded-2xl border border-kisii-border flex items-center gap-3">
            <MapPin className="w-5 h-5 sm:w-6 sm:h-6 text-kisii-blue shrink-0" />
            <p className="text-sm sm:text-base text-kisii-text-muted">
              <span className="font-semibold text-kisii-text">Kisii County Government Headquarters</span>
              {' '}— Kisii Town, Off Moi Highway, P.O. Box 1 – 40200, Kisii, Kenya
            </p>
          </div>
        </main>
      )}
    </div>
  );
}
