import { useState, useMemo, useEffect } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { ChevronLeft, Phone, Mail, Users, ArrowUpRight, User } from 'lucide-react';
import { fetchDepartment } from '../api';
import DeptIcon from '../components/DeptIcon';
import SearchBar from '../components/SearchBar';
import Highlight from '../components/Highlight';

function initials(name) {
  if (!name) return '';
  return name.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase();
}

// Skeleton components
function SeniorCardSkeleton() {
  return (
    <div className="bg-kisii-white rounded-2xl border border-kisii-border shadow-sm overflow-hidden animate-pulse">
      <div className="h-1.5 bg-kisii-blue/20" />
      <div className="p-6 md:p-8">
        <div className="h-4 bg-kisii-text-muted/10 rounded w-48 mb-5" />
        <div className="flex flex-col sm:flex-row gap-6">
          <div className="flex flex-col items-center sm:items-start gap-3 sm:w-56">
            <div className="w-28 h-28 rounded-2xl bg-kisii-blue/10" />
            <div className="h-3 bg-kisii-text-muted/10 rounded w-24 mt-2" />
            <div className="h-4 bg-kisii-text-muted/10 rounded w-32 mt-1" />
          </div>
          <div className="flex-1 flex flex-col gap-4">
            <div className="p-4 bg-kisii-surface rounded-xl border-l-4 border-kisii-blue/20 space-y-2">
              <div className="h-3 bg-kisii-text-muted/10 rounded w-20" />
              <div className="h-4 bg-kisii-text-muted/10 rounded w-full" />
              <div className="h-4 bg-kisii-text-muted/10 rounded w-5/6" />
            </div>
            <div className="bg-kisii-blue/10 rounded-xl p-4 space-y-2">
              <div className="h-3 bg-kisii-text-muted/10 rounded w-24" />
              <div className="h-4 bg-kisii-text-muted/10 rounded w-40" />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

function StaffCardSkeleton() {
  return (
    <div className="bg-kisii-white rounded-xl border border-kisii-border p-4 sm:p-5 animate-pulse shadow-sm">
      <div className="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-kisii-blue/10 mb-3" />
      <div className="h-4 bg-kisii-text-muted/10 rounded w-3/4 mb-2" />
      <div className="h-3 bg-kisii-text-muted/10 rounded w-1/2" />
    </div>
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
      <h3 className="font-bold text-red-800 text-lg mb-2">Error Loading Department</h3>
      <p className="text-sm text-red-600 mb-6 leading-relaxed">{message}</p>
      <div className="flex justify-center gap-3">
        <Link to="/" className="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors text-sm">
          Back to Home
        </Link>
        {onRetry && (
          <button
            onClick={onRetry}
            className="px-6 py-2 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-colors text-sm shadow-sm"
          >
            Try Again
          </button>
        )}
      </div>
    </div>
  );
}

function StaffCard({ contact, query, index }) {
  const colors = [
    'bg-kisii-blue/10 text-kisii-blue group-hover:bg-kisii-green/10 group-hover:text-kisii-green',
    'bg-kisii-green/10 text-kisii-green group-hover:bg-kisii-blue/10 group-hover:text-kisii-blue',
    'bg-kisii-gold/10 text-kisii-gold-dark group-hover:bg-kisii-blue/10 group-hover:text-kisii-blue',
  ];
  const colorClass = colors[index % colors.length];
  const init = initials(contact.name);

  return (
    <article className="bg-kisii-white rounded-xl border border-kisii-border p-4 sm:p-5
      hover:border-kisii-green hover:shadow-md transition-all duration-200 group animate-fade-in">
      <div className={`w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-sm sm:text-base font-bold mb-3 transition-all ${colorClass}`}>
        {init ? init : <User className="w-5 h-5 sm:w-6 sm:h-6" />}
      </div>

      {/* Role — prominent, first */}
      <p className="text-sm sm:text-base md:text-lg font-extrabold text-kisii-blue leading-tight tracking-tight">
        <Highlight text={contact.role} query={query} />
      </p>

      {/* Name — secondary */}
      {contact.name && (
        <h3 className="font-medium text-kisii-text text-xs sm:text-sm mt-1 leading-snug">
          <Highlight text={contact.name} query={query} />
        </h3>
      )}

      {/* Extension */}
      {contact.ext && (
        <a
          href={`tel:${contact.ext}`}
          className="inline-flex items-center gap-1 mt-2.5 text-xs sm:text-sm font-semibold
            text-kisii-green hover:text-kisii-blue transition-colors"
        >
          <Phone className="w-3 h-3 sm:w-3.5 sm:h-3.5" />
          <Highlight text={`Ext. ${contact.ext}`} query={query} />
        </a>
      )}
    </article>
  );
}

export default function Department() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [search, setSearch] = useState('');
  const [dept, setDept] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const loadDept = async () => {
    setLoading(true);
    setError(null);
    try {
      const data = await fetchDepartment(id);
      if (!data) {
        setError('The requested department does not exist.');
      } else {
        setDept(data);
      }
    } catch (err) {
      console.error(err);
      setError('Could not connect to the database to fetch department details.');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadDept();
  }, [id]);

  const filteredStaff = useMemo(() => {
    if (!dept || !dept.staff) return [];
    if (!search.trim()) return dept.staff;
    const q = search.toLowerCase();
    return dept.staff.filter(
      s =>
        (s.name && s.name.toLowerCase().includes(q)) ||
        s.role.toLowerCase().includes(q) ||
        (s.ext && s.ext.includes(q))
    );
  }, [search, dept]);

  const accentColor = dept && dept.accentColor ? (dept.accentColor.startsWith('#') ? dept.accentColor : `#${dept.accentColor}`) : '#1B4F8A';
  const staffCount = dept && dept.staff ? dept.staff.length : 0;

  return (
    <div className="min-h-screen bg-kisii-surface">
      {/* ── Top Nav ── */}
      <nav className="sticky top-0 z-20 bg-kisii-white/95 backdrop-blur border-b border-kisii-border">
        <div className="w-full px-4 sm:px-8 lg:px-16 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-3">
          <div className="flex items-center gap-3 flex-1 min-w-0">
            <button
              onClick={() => navigate(-1)}
              className="p-2 rounded-full hover:bg-kisii-surface text-kisii-blue transition-colors shrink-0"
              aria-label="Go back"
            >
              <ChevronLeft className="w-5 h-5 sm:w-6 sm:h-6" />
            </button>
            <div className="flex items-center gap-1.5 min-w-0">
              <span className="text-xs sm:text-sm text-kisii-text-muted hidden sm:block">
                <Link to="/" className="hover:text-kisii-blue transition-colors">Home</Link>
                {' / '}
              </span>
              <span className="font-bold text-kisii-text text-sm sm:text-base truncate">
                {loading ? 'Loading department...' : dept?.name || 'Department'}
              </span>
            </div>
          </div>
          {/* Compact search */}
          <div className="w-full sm:w-72">
            <SearchBar
              value={search}
              onChange={setSearch}
              placeholder="Filter staff…"
              compact
              disabled={loading || !!error}
            />
          </div>
        </div>
      </nav>

      <div className="w-full px-4 sm:px-8 lg:px-16 py-6 space-y-6 animate-slide-up">
        {error ? (
          <ErrorState message={error} onRetry={loadDept} />
        ) : loading ? (
          <>
            <SeniorCardSkeleton />
            <section className="space-y-4">
              <div className="h-6 bg-kisii-text-muted/10 rounded w-40 animate-pulse" />
              <div className="grid grid-cols-1 min-[480px]:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                {Array.from({ length: 6 }).map((_, i) => (
                  <StaffCardSkeleton key={i} />
                ))}
              </div>
            </section>
          </>
        ) : (
          <>
            {/* ── Senior Officer Hero Card ── */}
            {dept.senior && (
              <section className="bg-kisii-white rounded-2xl border border-kisii-border shadow-sm overflow-hidden">
                {/* Smooth Tricolor Gradient Stripe */}
                <div className="h-1.5 bg-gradient-to-r from-kisii-blue via-kisii-gold to-kisii-green" />

                <div className="p-6 md:p-8">
                  {/* Dept label */}
                  <p className="text-xs font-bold uppercase tracking-widest text-kisii-gold mb-5 flex items-center gap-2">
                    <span
                      className="inline-flex p-1.5 rounded-lg text-kisii-white"
                      style={{ backgroundColor: accentColor }}
                    >
                      <DeptIcon name={dept.icon} className="w-3.5 h-3.5" />
                    </span>
                    {dept.name}
                  </p>

                  <div className="flex flex-col sm:flex-row gap-6">
                    {/* Left — photo + name */}
                    <div className="flex flex-col items-center sm:items-start gap-3 sm:w-56">
                      <div
                        className="w-28 h-28 rounded-2xl bg-kisii-surface
                          ring-2 ring-kisii-gold ring-offset-2
                          flex items-center justify-center text-2xl font-extrabold text-kisii-blue
                          shadow-inner select-none"
                      >
                        {initials(dept.senior.name)}
                      </div>
                      <div className="text-center sm:text-left">
                        <p className="text-xs font-bold uppercase tracking-wider text-kisii-green">
                          {dept.senior.role}
                        </p>
                        <h1 className="text-xl font-bold text-kisii-text mt-0.5">
                          {dept.senior.name}
                        </h1>
                      </div>
                    </div>

                    {/* Right — message + contacts */}
                    <div className="flex-1 flex flex-col gap-4">
                      {/* Office message */}
                      {dept.senior.message && (
                        <div className="p-4 bg-kisii-surface rounded-xl border-l-4 border-kisii-blue">
                          <p className="text-xs font-semibold text-kisii-text-muted uppercase tracking-wide mb-1">
                            Office message
                          </p>
                          <p className="text-kisii-text text-sm leading-relaxed italic">
                            "{dept.senior.message}"
                          </p>
                        </div>
                      )}

                      {/* Contacts box */}
                      <div className="bg-kisii-blue rounded-xl p-4 text-kisii-white">
                        <p className="text-xs font-bold uppercase text-kisii-gold mb-3 tracking-wider">
                          Contact Information
                        </p>
                        <div className="space-y-2">
                          {dept.senior.ext && (
                            <a
                              href={`tel:${dept.senior.ext}`}
                              className="flex items-center gap-2.5 text-sm hover:text-kisii-gold-light transition-colors"
                            >
                              <Phone className="w-4 h-4 text-kisii-gold shrink-0" />
                              Extension: <span className="font-semibold">{dept.senior.ext}</span>
                            </a>
                          )}
                          {dept.senior.email && (
                            <a
                              href={`mailto:${dept.senior.email}`}
                              className="flex items-center gap-2.5 text-sm hover:text-kisii-gold-light transition-colors"
                            >
                              <Mail className="w-4 h-4 text-kisii-gold shrink-0" />
                              <span className="font-semibold">{dept.senior.email}</span>
                              <ArrowUpRight className="w-3 h-3 opacity-60" />
                            </a>
                          )}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            )}

            {/* ── Staff Directory ── */}
            <section>
              <div className="flex items-center gap-3 mb-4">
                <div className="w-1.5 h-7 rounded-full bg-kisii-gold" />
                <h2 className="text-xl sm:text-2xl font-bold text-kisii-text flex items-center gap-2">
                  <Users className="w-5 h-5 text-kisii-text-muted" />
                  Staff Directory
                </h2>
                <span className="ml-auto text-xs sm:text-sm font-semibold text-kisii-text-muted bg-kisii-border/60 px-3 py-1 rounded-full">
                  {filteredStaff.length} of {staffCount}
                </span>
              </div>

              {filteredStaff.length > 0 ? (
                <div className="grid grid-cols-1 min-[480px]:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                  {filteredStaff.map((staff, i) => (
                    <StaffCard key={i} contact={staff} query={search} index={i} />
                  ))}
                </div>
              ) : (
                <div className="text-center py-12 text-kisii-text-muted">
                  <Users className="w-10 h-10 mx-auto mb-3 opacity-20" />
                  <p className="font-medium text-base">No staff match your filter.</p>
                </div>
              )}
            </section>
          </>
        )}

        {/* Back link */}
        <div className="text-center pb-4">
          <Link
            to="/"
            className="inline-flex items-center gap-2 text-sm text-kisii-blue hover:text-kisii-green
              font-medium transition-colors underline-offset-2 hover:underline"
          >
            <ChevronLeft className="w-4 h-4" /> Back to all departments
          </Link>
        </div>
      </div>
    </div>
  );
}

