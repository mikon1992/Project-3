const kasusUji = [
    { harga: 50000, jumlah: 2, member: false }, 
    { harga: 100000, jumlah: 2, member: true },
    { harga: 25000, jumlah: 3, member: false }, 
    { harga: 150000, jumlah: 2, member: true },
    { harga: -5000, jumlah: 2, member: false }  
];

let i = 1;
for (const k of kasusUji) {
    console.log(`\n--- Kasus ${i++} ---`);
    
    if (k.harga <= 0 || k.jumlah <= 0) {
        console.log("Status: Error (Harga dan jumlah harus > 0)");
        continue;
    }

    let subtotal = k.harga * k.jumlah;
    let diskon = subtotal >= 200000 ? 20 : (subtotal >= 100000 ? 10 : 0);
    if (k.member) diskon += 5;
    if (diskon > 25) diskon = 25; 
    let nominalDiskon = subtotal * (diskon / 100);
    let totalBayar = subtotal - nominalDiskon;

    console.log(`Subtotal : Rp${subtotal}`);
    console.log(`Diskon   : ${diskon}% (Rp${nominalDiskon})`);
    console.log(`Total    : Rp${totalBayar}`);
}