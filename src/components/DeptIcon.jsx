import {
  Shield, Star, FileText, Monitor, Sprout,
  DollarSign, Map, Building2, BarChart3, Heart, Megaphone, Target,
} from 'lucide-react';

const ICON_MAP = {
  Shield, Star, FileText, Monitor, Sprout,
  DollarSign, Map, Building2, BarChart3, Heart, Megaphone, Target,
};

export default function DeptIcon({ name, className = 'w-5 h-5' }) {
  const Icon = ICON_MAP[name] ?? Shield;
  return <Icon className={className} />;
}
