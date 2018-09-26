export default function forEach(array, callback) {
  for (let i = 0; i < array.length; i++) {
    callback.call(null, array[i], i);
  }
}
