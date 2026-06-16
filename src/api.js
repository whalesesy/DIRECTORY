const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000/api';

export async function fetchDepartments() {
  const res = await fetch(`${API_BASE_URL}/departments`);
  if (!res.ok) throw new Error('Failed to fetch departments');
  const json = await res.json();
  return json.data;
}

export async function fetchDepartment(slug) {
  const res = await fetch(`${API_BASE_URL}/departments/${slug}`);
  if (!res.ok) {
    if (res.status === 404) {
      return null;
    }
    throw new Error('Failed to fetch department details');
  }
  const json = await res.json();
  return json.data;
}

export async function fetchCountyLines() {
  const res = await fetch(`${API_BASE_URL}/county-lines`);
  if (!res.ok) throw new Error('Failed to fetch county lines');
  const json = await res.json();
  return json.data;
}
