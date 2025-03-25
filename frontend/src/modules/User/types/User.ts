export default interface User {
  id?: string;
  name: string | null;
  phone: string | null;
  email: string | null;
  password: string | null;
  role_id: string | null;
  apt_id: string | null;
  suspend: boolean
}
