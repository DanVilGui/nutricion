/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fuzzy;

/**
 *
 * @author Dante
 */
public class Trapezoide extends Modelo{

    public double p1;
    public double p2;
    public double p3;
    public double p4;

  
    public Trapezoide( String nombre,double p1, double p2, double p3, double p4) {
        super(nombre);
        this.p1 = p1;
        this.p2 = p2;
        this.p3 = p3;
        this.p4 = p4;
        this.valores = new double[] {p1,p2,p3,p4};
    }

    
       @Override
    public double funcion(double x) {
        double a = p1;
        double b = p2;
        double c = p3;
        double d = p4;
        if (x <= a|| x>= d) {
            return 0;
        }
        if (x < b) {
            return (x - a) / (b - a);
        }
        if (x < c) {
            return 1;
        }
        return (d-x)/(d-c);
    }
    
    
}
