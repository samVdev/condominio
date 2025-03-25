export function checkOffset({ to, from, next }) {
    if (!to.query.offset) {
      next({ path: to.path, query: { ...to.query, offset: 0 } });
    } else {
      next();
    }
  }
  