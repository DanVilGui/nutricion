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
public class Triangulo extends Modelo {

    public double p1;
    public double p2;
    public double p3;

    public Triangulo(String nombre, double p1, double p2, double p3) {
        super(nombre);
        this.p1 = p1;
        this.p2 = p2;
        this.p3 = p3;
        this.valores = new double[]{p1, p2, p3};
    }

    @Override
    public double funcion(double x) {
        double a = p1;
        double m = p2;
        double b = p3;
        if (x <= a) {
            return 0;
        }
        if (x < m) {
            return (x - a) / (m - a);
        }
        if (x < b) {
            return (b - x) / (b - m);
        }
        return 1;
    }

}
