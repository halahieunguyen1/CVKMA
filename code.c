#include<stdio.h> // define the header file
#include <math.h>
int main()   // define the main function  
{  
    long long n;
    scanf("%lld", &n);
    long long m = 9;
    short k = 1;
    while (n > m * k) {
        n = n - m * k;
        k++;
        m *= 10;
    }
    long long index = 1;
    printf("%lld\n", n );  // print the statement.  
    printf("%lld\n", k );  // print the statement.  
    for (int j = k - 1 - n % k; j >0; j--) {
        index = index * 10;
    };
    n = m / 9 + (n - 1) / k;
    printf("%lld\n", n );  // print the statement.  
    printf("%lld\n", index );  // print the statement.  

    printf("%lld", (n / index) % 10);  // print the statement.  
    return 0;
}  