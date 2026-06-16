import { useState, useMemo, useEffect } from 'react';
import { Phone, ChevronRight, MapPin, Globe } from 'lucide-react';
import { Link } from 'react-router-dom';
import { fetchDepartments, fetchCountyLines } from '../api';
import SearchBar from '../components/SearchBar';
import DeptIcon from '../components/DeptIcon';
import Highlight from '../components/Highlight';

// Skeleton Components
function StatCardSkeleton() {
  return (
    <div className="bg-kisii-white rounded-2xl border border-kisii-border p-4 sm:p-6 text-center shadow-sm animate-pulse">
      <div className="h-8 bg-kisii-blue/10 rounded w-16 mx-auto mb-2" />
      <div className="h-4 bg-kisii-text-muted/10 rounded w-24 mx-auto" />
    </div>
  );
}

function DeptCardSkeleton() {
  return (
    <div className="bg-kisii-white rounded-2xl border border-kisii-border border-t-4 border-t-kisii-blue/10 p-4 sm:p-5 animate-pulse shadow-sm">
      <div className="w-10 h-10 rounded-xl bg-kisii-blue/10 mb-3" />
      <div className="h-4 bg-kisii-text-muted/10 rounded w-3/4 mb-2" />
      <div className="h-3 bg-kisii-text-muted/10 rounded w-1/2" />
    </div>
  );
}

function HotlineSkeleton() {
  return (
    <div className="w-36 h-9 rounded-full bg-white/10 animate-pulse" />
  );
}

function ErrorState({ message, onRetry }) {
  return (
    <div className="max-w-md mx-auto my-12 p-6 bg-red-50 border border-red-200 rounded-2xl text-center shadow-sm animate-fade-in">
      <div className="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>
      <h3 className="font-bold text-red-800 text-lg mb-2">Connection Error</h3>
      <p className="text-sm text-red-600 mb-6 leading-relaxed">{message}</p>
      <button
        onClick={onRetry}
        className="px-6 py-2.5 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-colors shadow-sm"
      >
        Try Again
      </button>
    </div>
  );
}

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
        {contact.name ? contact.name.split(' ').map(n => n[0]).join('').slice(0, 2) : 'ST'}
      </div>
      <div className="flex-1 min-w-0">
        {/* Role — prominent, first */}
        <p className="text-sm sm:text-base font-extrabold text-kisii-blue leading-tight group-hover:text-kisii-green transition-colors">
          <Highlight text={contact.role} query={query} />
        </p>
        {/* Name — secondary */}
        <p className="font-medium text-kisii-text text-xs sm:text-sm mt-0.5">
          <Highlight text={contact.name || 'Staff Member'} query={query} />
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
      style={{ borderTopColor: dept.accentColor ? (dept.accentColor.startsWith('#') ? dept.accentColor : `#${dept.accentColor}`) : '#1B4F8A' }}
    >
      <div className="p-4 sm:p-5">
        <div className="inline-flex p-2.5 rounded-xl bg-kisii-blue text-kisii-gold mb-3">
          <DeptIcon name={dept.icon} />
        </div>
        <h3 className="font-bold text-kisii-text group-hover:text-kisii-blue transition-colors text-sm sm:text-base leading-tight">
          {dept.name}
        </h3>
        <p className="text-xs sm:text-sm text-kisii-text-muted mt-1.5 font-medium">
          {dept.staff ? dept.staff.length + 1 : 1} contacts
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
  const [departments, setDepartments] = useState([]);
  const [countyLines, setCountyLines] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const loadData = async () => {
    setLoading(true);
    setError(null);
    try {
      const [deptsData, linesData] = await Promise.all([
        fetchDepartments(),
        fetchCountyLines(),
      ]);
      setDepartments(deptsData);
      setCountyLines(linesData);
    } catch (err) {
      console.error(err);
      setError('Could not connect to the Kisii County Government directory database. Please verify the backend API is running.');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadData();
  }, []);

  const searchIndex = useMemo(() => {
    const entries = [];
    for (const dept of departments) {
      if (dept.senior) {
        entries.push({
          type: 'senior',
          deptId: dept.id,
          deptName: dept.name,
          name: dept.senior.name,
          role: dept.senior.role,
          ext: dept.senior.ext,
        });
      }
      if (dept.staff) {
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
    }
    return entries;
  }, [departments]);

  const results = useMemo(() => {
    if (!search.trim()) return [];
    const q = search.toLowerCase();
    return searchIndex.filter(
      c =>
        c.name.toLowerCase().includes(q) ||
        c.role.toLowerCase().includes(q) ||
        (c.ext && c.ext.includes(q)) ||
        c.deptName.toLowerCase().includes(q)
    ).slice(0, 20);
  }, [search, searchIndex]);

  const totalContacts = useMemo(() => {
    return departments.reduce((acc, dept) => {
      let count = 0;
      if (dept.senior) count += 1;
      if (dept.staff) count += dept.staff.length;
      return acc + count;
    }, 0);
  }, [departments]);

  return (
    <div className="min-h-screen bg-kisii-surface">
      {/* ── Hero ── */}
      <header className="relative overflow-hidden text-white bg-gradient-to-br from-kisii-blue-dark via-kisii-blue to-kisii-green-dark py-12 sm:py-16">
        {/* Tricolor flag banner at the top of the header */}
        <div className="absolute top-0 left-0 right-0 flex h-1.5 pointer-events-none">
          <div className="flex-[2] bg-kisii-blue" />
          <div className="flex-[1] bg-kisii-white" />
          <div className="flex-[2] bg-kisii-green" />
        </div>

        {/* Subtle overlay pattern */}
        <div className="absolute inset-0 opacity-[0.03] pointer-events-none"
          style={{
            backgroundImage: 'repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%)',
            backgroundSize: '20px 20px',
          }}
        />
        {/* Decorative ambient radial gradient */}
        <div className="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(212,160,23,0.15),transparent_40%)] pointer-events-none" />

        <div className="relative z-10 w-full px-4 sm:px-8 lg:px-16 text-center">
          {/* Kenya badge */}
          <div className="inline-flex items-center gap-2 mb-4">
            <div className="w-12 h-0.5 bg-kisii-gold rounded-full" />
            <p className="text-kisii-gold text-xs sm:text-sm font-bold tracking-widest uppercase select-none">
              Republic of Kenya
            </p>
            <div className="w-12 h-0.5 bg-kisii-gold rounded-full" />
          </div>

          {/* County seal / logo */}
          <div className="inline-flex items-center justify-center mb-5">
            <img 
              src={`${import.meta.env.BASE_URL}kisii-logo.png`} 
              alt="Kisii County Government Logo"
              className="h-20 w-20 sm:h-24 sm:w-24 object-contain drop-shadow-lg animate-fade-in"
            />
          </div>

          <h1 className="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white drop-shadow-sm tracking-tight">
            Kisii County
          </h1>
          <p className="text-lg sm:text-xl md:text-2xl text-kisii-gold-light font-bold mt-1.5 mb-1.5 tracking-wide uppercase">
            Government Directory
          </p>
          <p className="text-white/90 text-sm sm:text-base mb-8 max-w-2xl mx-auto font-medium">
            Find any office, officer, or extension in the county government
          </p>

          {/* Search */}
          <div className="max-w-2xl mx-auto">
            <SearchBar value={search} onChange={setSearch} placeholder={loading ? "Loading directory..." : "Search by name, role, department or extension..."} />
          </div>

          {/* County hotlines */}
          <div className="flex flex-wrap justify-center gap-3 mt-6">
            {loading ? (
              <>
                <HotlineSkeleton />
                <HotlineSkeleton />
              </>
            ) : (
              countyLines.map(line => (
                <a
                  key={line.id || line.number}
                  href={`tel:${line.number}`}
                  className="inline-flex items-center gap-2 border border-kisii-gold/40
                    bg-kisii-blue-dark/50 hover:bg-kisii-blue-dark/80 backdrop-blur-md
                    px-4 py-2 rounded-full text-xs sm:text-sm transition-all duration-200 font-semibold text-white/95"
                >
                  <Phone className="w-3.5 h-3.5 text-kisii-gold" />
                  {line.label}: <span className="text-kisii-gold-light">{line.number}</span>
                </a>
              ))
            )}
          </div>
        </div>
      </header>

      {/* ── Search Results ── */}
      {search.trim() && !loading && !error && (
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

      {/* ── Main Content Area (Loading, Error, or Departments Grid) ── */}
      {!search.trim() && (
        <main className="w-full px-4 sm:px-8 lg:px-16 py-8">
          {error ? (
            <ErrorState message={error} onRetry={loadData} />
          ) : (
            <>
              {/* Stats bar */}
              <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
                {loading ? (
                  <>
                    <StatCardSkeleton />
                    <StatCardSkeleton />
                    <StatCardSkeleton />
                  </>
                ) : (
                  [
                    { label: 'Departments', value: departments.length, color: 'text-kisii-blue' },
                    { label: 'Total Contacts', value: totalContacts, color: 'text-kisii-green' },
                    { label: 'County Lines', value: countyLines.length, color: 'text-kisii-gold' },
                  ].map(stat => (
                    <div key={stat.label} className="bg-kisii-white rounded-2xl border border-kisii-border p-4 sm:p-6 text-center shadow-sm">
                      <p className={`text-3xl sm:text-4xl md:text-5xl font-extrabold ${stat.color}`}>{stat.value}</p>
                      <p className="text-xs sm:text-sm md:text-base text-kisii-text-muted mt-1 font-semibold">{stat.label}</p>
                    </div>
                  ))
                )}
              </div>

              {/* Section header */}
              <div className="flex items-center gap-3 mb-5">
                <div className="w-1.5 h-7 rounded-full bg-kisii-gold" />
                <h2 className="text-2xl sm:text-3xl font-bold text-kisii-text">Departments</h2>
              </div>

              <div className="grid grid-cols-1 min-[480px]:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                {loading ? (
                  Array.from({ length: 12 }).map((_, i) => <DeptCardSkeleton key={i} />)
                ) : (
                  departments.map(dept => (
                    <DeptCard key={dept.id} dept={dept} />
                  ))
                )}
              </div>
            </>
          )}

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

